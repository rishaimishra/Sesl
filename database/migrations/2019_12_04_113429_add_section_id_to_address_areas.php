<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSectionIdToAddressAreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('address_areas', function (Blueprint $table) {
            $table->unsignedBigInteger('address_section_id')->after('address_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('address_areas', function (Blueprint $table) {
            if (Schema::hasColumn('address_areas', 'address_section_id'))
            {
                $table->dropColumn('address_section_id');
            }
        });
    }
}
