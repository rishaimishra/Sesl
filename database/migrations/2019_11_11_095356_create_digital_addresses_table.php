<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDigitalAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('address_area_id');
            $table->unsignedBigInteger('address_chiefdom_id');
            $table->unsignedBigInteger('address_section_id');
            $table->string('type');
            $table->string('digital_addresses');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->foreign('address_id')
                ->references('id')
                ->on('addresses');

            $table->foreign('address_area_id')
                ->references('id')
                ->on('address_areas');

            $table->foreign('address_chiefdom_id')
                ->references('id')
                ->on('address_chiefdoms');

            $table->foreign('address_section_id')
                ->references('id')
                ->on('address_sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('digital_addresses');
    }
}
