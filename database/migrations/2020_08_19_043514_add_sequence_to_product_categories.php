<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSequenceToProductCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->string('sponsor_text')->after('is_active')->nullable();
            $table->unsignedBigInteger('sequence')->after('is_active')->nullable();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('sequence')->after('is_active')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropColumn('sequence');
            $table->dropColumn('sponsor_text');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('sequence');
        });
    }
}
