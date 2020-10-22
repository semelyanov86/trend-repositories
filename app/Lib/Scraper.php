<?php

namespace App\Lib;

use App\Models\Commit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class Scraper
 *
 * handles and process scraping using specific link
 * first we work on the main filter expression which is the
 * the container of the items, then using annonymous callback
 * on the filter function we iterate and save the results
 * into the commits table
 *
 * @package App\Lib
 */
class Scraper
{
    protected string $url;

    public array $results = [];

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /*
     * schedule
     *
     * This method receive links to parse specific repository
     */
    public function init()
    {
        $crawler = $this->getCrawler($this->url);
        if ($crawler) {
            $items = $this->getScanItems($crawler);
        } else {
            $items = collect([]);
        }
        $this->initQueue($items);
    }

    /**
     * Function accepts list of url and run their parsing
     * @param  Collection  $items
     */
    public function initQueue(Collection $items)
    {
        $items->each(function($url) {
            $model = $this->getParsedModel($url);
            $this->results[] = $this->createCommit($model);
        });
    }

    /**
     * Generates parsed collection of current url
     * @param  string  $url
     * @return Collection
     */
    protected function getParsedModel(string $url) : Collection
    {
        $crawler = $this->getCrawler($url);
        if ($crawler->filter('img.avatar-user')->count()) {
            $avatar = $crawler->filter('img.avatar-user')->first()->attr('src');
        } else {
            $avatar = $crawler->filter('img.avatar')->first()->attr('src');
        }
        $login = $crawler->filter('div.AvatarStack-body')->first()->attr('aria-label');
        $message = $crawler->filter('div.js-details-container')->first()->filter('a.link-gray-dark')->first()->text();
        $date = Carbon::parse($crawler->filter('relative-time')->first()->text());
        return collect([
            'repository' => $url,
            'avatar' => $avatar,
            'login' => $login,
            'message' => $message,
            'commit_date' => $date
        ]);
    }


    private function getIntValue(Crawler $collection, $fromParent = true) : ?int
    {
        if ($fromParent && $collection->count() > 0) {
            $collection = $collection->parents();
        }
        if ($collection->count() > 0) {
            return $this->convertToInt($collection->text());
        } else {
            return null;
        }
    }

    /**
     * Getting list of 10 most popular commits
     * @param  Crawler  $crawler
     * @return Collection
     */
    private function getScanItems(Crawler $crawler) : Collection
    {
        $urls = collect([]);
        $crawler->filter('article.Box-row')->each(function(Crawler $node, $i) use (&$urls){
            $urls->push($node->filter('h1.lh-condensed')->filter('a')->first()->attr('href'));
        });
        return $urls->take(config('app.urls_limit'))->map(function($url) {
            return 'https://github.com' . $url;
        });
    }

    /**
     * Creates new crawler model
     * @param  string  $url
     * @return Crawler|null
     */
    private function getCrawler(string $url) : ?Crawler
    {
        $response = Http::get($url);
        if ($response->ok()) {
            return new Crawler($response->body());
        } else {
            Log::error("Get server error during parser: " . $response->status());
        }
        return null;
    }

    /**
     * Update or create new Commit model
     * @param  Collection  $parsed
     * @return Commit
     */
    protected function createCommit(Collection $parsed) : Commit
    {
        return Commit::updateOrCreate(['repository' => $parsed->get('repository')], $parsed->toArray());
    }

    private function convertToInt(string $s) : int
    {
        return (int)preg_replace('/[^\-\d]*(\-?\d*).*/','$1',$s);
    }

    private function getFloat(string $str) : float
    {
        if(strstr($str, ",")) {
            $str = str_replace(".", "", $str); // replace dots (thousand seps) with blancs
            $str = str_replace(",", ".", $str); // replace ',' with '.'
        }

        if(preg_match("#([0-9\.]+)#", $str, $match)) { // search for number that may contain '.'
            return floatval($match[0]);
        } else {
            return floatval($str); // take some last chances with floatval
        }
    }

}
