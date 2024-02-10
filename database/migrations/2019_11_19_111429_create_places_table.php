<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->longText('about');
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('chiefdom_id');
            $table->unsignedBigInteger('section_id');
            $table->string('type');
            $table->string('digital_addresses');
            $table->string('map_addresses');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->text('availability_times')->nullable();
            $table->string('meta_tag1')->nullable();
            $table->string('meta_tag2')->nullable();
            $table->string('meta_tag3')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->foreign('address_id')
                ->references('id')
                ->on('addresses');

            $table->foreign('area_id')
                ->references('id')
                ->on('address_areas');

            $table->foreign('chiefdom_id')
                ->references('id')
                ->on('address_chiefdoms');

            $table->foreign('section_id')
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
        Schema::dropIfExists('places');
    }
}
