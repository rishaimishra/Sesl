<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSequenceToProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->unsignedBigInteger('sequence')->after('meta_tag3')->nullable();
        });

        Schema::table('autos', function (Blueprint $table) {
            $table->unsignedBigInteger('sequence')->after('meta_tag3')->nullable();
        });

        Schema::table('real_estates', function (Blueprint $table) {
            $table->unsignedBigInteger('sequence')->after('meta_tag3')->nullable();
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
            $table->dropColumn('sequence');
        });

        Schema::table('autos', function (Blueprint $table) {
            $table->dropColumn('sequence');
        });

        Schema::table('real_estates', function (Blueprint $table) {
            $table->dropColumn('sequence');
        });

    }
}
