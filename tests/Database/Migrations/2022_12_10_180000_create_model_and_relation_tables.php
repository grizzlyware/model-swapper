<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends \Illuminate\Database\Migrations\Migration {
    public function up()
    {
        Schema::create('continents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
};
