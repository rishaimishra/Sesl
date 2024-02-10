<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoAutoCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_auto_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('auto_id');
            $table->unsignedBigInteger('auto_category_id');

            $table->foreign('auto_id')
                ->references('id')
                ->on('autos')
                ->onDelete('cascade');

            $table->foreign('auto_category_id')
                ->references('id')
                ->on('auto_categories')
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
        Schema::dropIfExists('auto_auto_categories');
    }
}
