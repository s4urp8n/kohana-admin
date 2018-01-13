<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tables extends Migration
{
    public function up()
    {
        $this->down();

        Schema::create('news', function (Blueprint $table) {

            $table->unsignedBigInteger('id', true);

            $table->longText("image")
                  ->nullable();

            $table->string("title", 180)
                  ->index();

            $table->dateTime("date")
                  ->index();

            $table->longText("text")
                  ->nullable();

        });

        Schema::create('products_categories', function (Blueprint $table) {

            $table->unsignedBigInteger('id', true);

            $table->string("category")
                  ->unique();

        });

        Schema::create('products', function (Blueprint $table) {

            $table->unsignedBigInteger('id', true);

            $table->unsignedBigInteger("id_category");

            $table->string("name", 180)
                  ->index();

            $table->string("weight", 180)
                  ->nullable();

            $table->string("unit", 180)
                  ->nullable();

            $table->string("price", 180)
                  ->nullable();

        });

        Schema::create('specs', function (Blueprint $table) {

            $table->unsignedBigInteger('id', true);

            $table->string("name", 180)
                  ->index();

            $table->string("length", 180)
                  ->nullable();

            $table->string("gost", 180)
                  ->nullable();
            $table->string("weightT", 180)
                  ->nullable();
            $table->string("weightM", 180)
                  ->nullable();
            $table->string("img", 180)
                  ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
        Schema::dropIfExists('products_categories');
        Schema::dropIfExists('products');
        Schema::dropIfExists('specs');
    }
}
