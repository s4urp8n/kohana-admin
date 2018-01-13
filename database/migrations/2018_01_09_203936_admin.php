<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Admin extends Migration
{
    public function up()
    {

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')
                  ->index()
                  ->default(0);
        });

    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
}
