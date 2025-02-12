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
        Schema::table('evaluations', function (Blueprint $table) {
            // type カラムを削除
            $table->dropColumn('type');

            // id カラムの後ろに user_id を追加 (varchar(255), nullable)
            $table->string('user_id', 255)->nullable()->after('id');

            // user_id カラムの後ろに art_id を追加 (varchar(255), nullable)
            $table->string('art_id', 255)->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluations', function (Blueprint $table) {
            // up()で削除した type カラムを再度追加（元の型に合わせて指定）
            $table->string('type')->nullable();

            // up()で追加した user_id, art_id カラムを削除
            $table->dropColumn(['user_id', 'art_id']);
        });
    }
};
