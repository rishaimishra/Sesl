<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOpenLocationCodeToDigitalAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('digital_addresses', function (Blueprint $table) {
            $table->string('open_location_code')->after('digital_addresses')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('digital_addresses', function (Blueprint $table) {
            $table->dropColumn('open_location_code');
        });
    }
}
