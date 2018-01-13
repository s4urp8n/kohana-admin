<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminUser extends Migration
{

    public function up()
    {

        $users = [
            'admin' => 1,
            'user'  => 0
        ];

        foreach ($users as $user => $isAdmin) {

            $dbUser = new \App\User();
            $dbUser->password = bcrypt($user);
            $dbUser->email = $user . '@' . $user . '.' . $user;
            $dbUser->name = $user;
            $dbUser->is_admin = $isAdmin;
            $dbUser->save();

        }
    }

    public function down()
    {
        DB::table('users')
          ->delete();
    }
}
