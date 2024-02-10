<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealEstateRealEstateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estate_real_estate_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('real_id');
            $table->unsignedBigInteger('real_category_id');

            $table->foreign('real_id')
                ->references('id')
                ->on('real_estates')
                ->onDelete('cascade');

            $table->foreign('real_category_id')
                ->references('id')
                ->on('real_estate_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('real_estate_real_estate_categories');
    }
}
