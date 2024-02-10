<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleToPlaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->string('title')->after('user_id')->nullable();
        });
        Schema::table('autos', function (Blueprint $table) {
            $table->string('title')->after('user_id')->nullable();
        });

        Schema::table('real_estates', function (Blueprint $table) {
            $table->string('title')->after('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('places', function (Blueprint $table) {
            $table->dropColumn('title');
        });

        Schema::table('autos', function (Blueprint $table) {
            $table->dropColumn('title');
        });

        Schema::table('real_estates', function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }
}
