<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RemoveAutoIncrementFromImageQuestionsId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // AUTO_INCREMENT 属性を削除するSQL文
        DB::statement('ALTER TABLE image_questions MODIFY id INT(11) NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // ロールバック時は AUTO_INCREMENT 属性を再設定
        DB::statement('ALTER TABLE image_questions MODIFY id INT(11) NOT NULL AUTO_INCREMENT');
    }
}
