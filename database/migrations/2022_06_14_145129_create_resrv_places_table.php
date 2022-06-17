<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserv_places', function (Blueprint $table) {
            $table->id();
            $table->integer('trip_user_id')->unsigned();
            $table->integer('place_id')->unsigned();
            $table->foreign('trip_user_id')->references('id')->on('trip_user')->onDelete('cascade');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');

        });}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserv_places');
    }
};
