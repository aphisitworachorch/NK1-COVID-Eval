<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeignKeyCareAndChurch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questionaire_answers', function (Blueprint $table) {
            $table->bigInteger('church')->change();
            $table->bigInteger('care_group')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questionaire_answers', function (Blueprint $table) {
            $table->dropColumn('church');
            $table->dropColumn('care_group');
        });
    }
}
