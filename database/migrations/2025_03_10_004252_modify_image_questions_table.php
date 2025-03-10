<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::table('image_questions', function (Blueprint $table) {
            $table->char('id', 36)->change();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('image_questions', function (Blueprint $table) {
            $table->unsignedInteger('id')->change();
        });
    }
};
