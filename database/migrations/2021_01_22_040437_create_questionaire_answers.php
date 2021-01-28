<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionaireAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionaire_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('questionaire_id');
            $table->foreign('id')->references('questionaire_id')->on('questionaire_prototype');
            $table->string('prefix');
            $table->string('name');
            $table->string('surname');
            $table->string('church');
            $table->string('care_group');
            $table->json('answers')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionaire_answers');
    }
}
