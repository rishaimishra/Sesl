<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('order_type')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('order_status')->nullable();
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('address_area_id');
            $table->unsignedBigInteger('address_chiefdom_id');
            $table->unsignedBigInteger('address_section_id');
            $table->string('digital_addresses');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->decimal('digital_administration', 10, 2);
            $table->decimal('transport', 10, 2);
            $table->decimal('fuel', 10, 2);
            $table->decimal('gst', 10, 2);
            $table->decimal('sub_total', 10, 2);
            $table->decimal('tip', 10, 2);
            $table->decimal('grand_total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
