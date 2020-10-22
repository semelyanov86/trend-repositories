<?php

namespace App\Console\Commands;

use App\Lib\Scraper;
use Illuminate\Console\Command;

class InitParsing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse git trend commits';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $scraper = new Scraper(config('app.parser_url'));
        $scraper->init();
    }
}
