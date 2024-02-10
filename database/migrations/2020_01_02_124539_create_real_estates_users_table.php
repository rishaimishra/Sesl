<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealEstatesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estate_interested_user', function (Blueprint $table) {
            $table->unsignedBigInteger('real_estate_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('real_estate_id')
                ->references('id')
                ->on('real_estates')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('real_estate_interested_user');
    }
}
