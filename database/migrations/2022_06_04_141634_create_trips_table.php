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
        Schema::table('trips', function (Blueprint $table) {
            Schema::create('trips', function (Blueprint $table) {
                $table->increments('id');
                $table->string('trip_name')->nullable();
                $table->string('photo')->nullable();
                $table->date('trip_start')->nullable();
                $table->date('trip_end')->nullable();
                $table->double('duration')->nullable();
                $table->string('trip_plane')->nullable();
                $table->string('trip_status')->nullable();
                $table->double('price')->nullable();
                $table->string('note')->nullable();
                $table->integer('available_num_passenger')->nullable();
            });

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trips', function (Blueprint $table) {
            Schema::dropIfExists('trips');
        });
    }
};
