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
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // 自動増分の主キー
            $table->unsignedBigInteger('art_id'); // artテーブルへの外部キー
            $table->unsignedBigInteger('user_id'); // usersテーブルへの外部キー
            $table->text('comment'); // コメント本文（text型を使用）
            $table->timestamps(); // created_at, updated_atカラム

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};