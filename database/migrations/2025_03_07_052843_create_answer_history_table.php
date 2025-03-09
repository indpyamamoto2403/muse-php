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
        Schema::create('answer_history', function (Blueprint $table) {
            $table->id(); // 自動増分の主キー
            $table->unsignedBigInteger('user_id'); // user_id (外部キー)
            $table->unsignedBigInteger('question_id'); // question_id (外部キー)
            $table->enum('answer', ['yes', 'no', 'not_answered']); // answer カラム (enum型)
            $table->timestamps(); // created_at, updated_at カラム

            // 外部キー制約 (users テーブルと questions テーブルが存在する場合)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_history');
    }
};