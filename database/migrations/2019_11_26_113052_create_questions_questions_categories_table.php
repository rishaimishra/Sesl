<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsQuestionsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('knowledgebase_categories_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('questions_id');
            $table->unsignedBigInteger('knowledge_cat_id');

            $table->foreign('questions_id')
                ->references('id')
                ->on('questions')
                ->onDelete('cascade');

            $table->foreign('knowledge_cat_id')
                ->references('id')
                ->on('knowledgebase_categories')
                ->onDelete('cascade');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('knowledgebase_categories_questions');
    }
}
