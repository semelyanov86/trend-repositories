<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommitsTable extends Migration
{
    public function up()
    {
        Schema::create('commits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('repository')->nullable();
            $table->string('avatar')->nullable();
            $table->string('login')->nullable();
            $table->string('message')->nullable();
            $table->datetime('commit_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
