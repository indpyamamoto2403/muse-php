<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSelectedImagesTable extends Migration
{
    public function up()
    {
        Schema::create('user_selected_image', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('image_question_id');
            $table->boolean('is_former_selected')->default(false);
            $table->timestamps();
    
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_selected_image');
    }
}
