<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersRoleEnum extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // doctrine/dbalパッケージが必要です
            $table->enum('role', ['company', 'artist', 'admin'])->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['company', 'artist'])->change();
        });
    }
}
