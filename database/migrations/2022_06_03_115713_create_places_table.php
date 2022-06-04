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
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->string('place_name')->nullable();
            $table->time('time_open')->nullable();
            $table->time('time_close')->nullable();
            $table->string('fees')->nullable();
            $table->string('location')->nullable();
            $table->double('langtiude')->nullable();
            $table->double('latitude')->nullable();
            $table->integer('rate')->nullable();
            $table->integer('country_id')->unsigned();
            $table->index('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
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
            $table->dropForeign('places_country_id_foreign');
            $table->dropIndex('places_country_id_index');
            $table->dropColumn('country_id');
        });
    }
};
