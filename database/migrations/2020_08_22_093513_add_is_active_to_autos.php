<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveToAutos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('autos', function (Blueprint $table) {

            $table->boolean('is_available')->default(false)->after('sequence');
        });

        Schema::table('real_estates', function (Blueprint $table) {
            $table->boolean('is_available')->default(false)->after('sequence');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('autos', function (Blueprint $table) {
            $table->dropColumn('is_available');
        });

        Schema::table('real_estates', function (Blueprint $table) {
            $table->dropColumn('is_available');
        });
    }
}
