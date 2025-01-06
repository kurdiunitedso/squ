<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallQuestionnaireQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_questionnaire_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('call_questionnaire_id');
            $table->string('text');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('call_questionnaire_id', 'call_questionnaire_questions_call_questionnaire_id_foreign')->references('id')->on('call_questionnaires');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('call_questionnaire_questions');
    }
}
