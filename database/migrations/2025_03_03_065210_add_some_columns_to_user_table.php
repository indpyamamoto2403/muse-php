<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // profile_photo_pathの後にoccupationを追加
            $table->string('occupation')
                  ->nullable()
                  ->after('profile_photo_path');

            // occupationの後にself_introductionを追加
            $table->text('self_introduction')
                  ->nullable()
                  ->after('occupation');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['occupation', 'self_introduction']);
        });
    }
};