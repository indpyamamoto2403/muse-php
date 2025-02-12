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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            // user or art
            $table->enum('type', ['user', 'art']);
            // 作風
            $table->enum('style', ['1','2','3','4','5']);
            // 伝統的～革新的
            $table->enum('tradition_innovation', ['1','2','3','4','5']);
            // 内省的～感情的
            $table->enum('introspective_emotional', ['1','2','3','4','5']);
            // 色彩感覚
            $table->enum('color_sense', ['1','2','3','4','5']);
            // 構図
            $table->enum('composition', ['1','2','3','4','5']);
            // 技法
            $table->enum('technique', ['1','2','3','4','5']);
            // テーマ性
            $table->enum('theme', ['1','2','3','4','5']);
            // エネルギー
            $table->enum('energy', ['1','2','3','4','5']);
            // 全体の独自性・創造性
            $table->enum('uniqueness', ['1','2','3','4','5']);
            // timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
