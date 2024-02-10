<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSponsorTextToPlaceCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('place_categories', function (Blueprint $table) {
            $table->string('sponsor_text')->after('is_active')->nullable();
            $table->unsignedBigInteger('sequence')->after('is_active')->nullable();
        });
        Schema::table('auto_categories', function (Blueprint $table) {
            $table->string('sponsor_text')->after('is_active')->nullable();
            $table->unsignedBigInteger('sequence')->after('is_active')->nullable();
        });
        Schema::table('knowledgebase_categories', function (Blueprint $table) {
            $table->string('sponsor_text')->after('is_active')->nullable();
            $table->unsignedBigInteger('sequence')->after('is_active')->nullable();
        });
        Schema::table('real_estate_categories', function (Blueprint $table) {
            $table->string('sponsor_text')->after('is_active')->nullable();
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
        Schema::table('place_categories', function (Blueprint $table) {
            $table->dropColumn('sponsor_text');
            $table->dropColumn('sequence');
        });
        Schema::table('auto_categories', function (Blueprint $table) {
            $table->dropColumn('sponsor_text');
            $table->dropColumn('sequence');
        });
        Schema::table('knowledgebase_categories', function (Blueprint $table) {
            $table->dropColumn('sponsor_text');
            $table->dropColumn('sequence');
        });
        Schema::table('real_estate_categories', function (Blueprint $table) {
            $table->dropColumn('sponsor_text');
            $table->dropColumn('sequence');
        });
    }
}
