<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallQuestionnaireResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_questionnaire_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('call_id')->index('call_questionnaire_responses_call_id_foreign');
            $table->unsignedBigInteger('call_questionnaire_id');
            $table->unsignedBigInteger('cq_question_id');
            $table->text('answer');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('module')->nullable();
            
            $table->foreign('call_questionnaire_id', 'call_questionnaire_responses_call_questionnaire_id_foreign')->references('id')->on('call_questionnaires');
            $table->foreign('cq_question_id', 'call_questionnaire_responses_cq_question_id_foreign')->references('id')->on('call_questionnaire_questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('call_questionnaire_responses');
    }
}
