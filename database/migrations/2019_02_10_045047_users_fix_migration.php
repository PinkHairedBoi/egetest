<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersFixMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_test_id_foreign');
            $table->dropForeign('users_question_id_foreign');
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('set null');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('set null');
        });
            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
