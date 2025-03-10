<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('image_questions', function (Blueprint $table) {
            $table->id();
            $table->string('image_path1');
            $table->string('image_path2');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('image_questions');
    }
}

