<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableQuestionairePrototype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questionaire_prototype', function (Blueprint $table) {
            $table->string('translation',10);
        });
        Schema::table('questionaire_prototype_details', function (Blueprint $table) {
            $table->string('translation',10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questionaire_prototype', function (Blueprint $table) {
            $table->dropColumn('translation');
        });
        Schema::table('questionaire_prototype_details', function (Blueprint $table) {
            $table->dropColumn('translation');
        });
    }
}
