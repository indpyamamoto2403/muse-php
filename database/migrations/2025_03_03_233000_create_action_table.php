<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // likesテーブル
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('art_id');
            $table->timestamps();
            
            $table->unique(['user_id', 'art_id']); // 重複防止
        });

        // savesテーブル
        Schema::create('saves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('art_id');
            $table->timestamps();
            
            $table->unique(['user_id', 'art_id']); // 重複防止
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
        Schema::dropIfExists('saves');
    }
};
