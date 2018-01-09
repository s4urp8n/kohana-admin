<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminUser extends Migration
{

    public function up()
    {
        $admin = new \App\User();

        $admin->password = '$2y$10$p8dkrDGqfin08BIfCpFSP.6GIxWsnuAdTH8P1dgv6GmDf.l.qVA0m';
        $admin->email = 'admin@admin.admin';
        $admin->name = 'admin';
        $admin->is_admin = 1;
        $admin->save();
    }

    public function down()
    {
        DB::table('users')->delete();
    }
}
