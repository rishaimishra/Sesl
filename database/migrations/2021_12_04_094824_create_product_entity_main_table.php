<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductEntityMainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('products', function (Blueprint $table) {
			$table->integer('entity_id')->unsigned()->after('id');
			$table->integer('attribute_set_id')->unsigned()->after('entity_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('entity_id');
            $table->dropColumn('attribute_set_id');
        });
    }
}
