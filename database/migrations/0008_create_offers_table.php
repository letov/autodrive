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
        Schema::dropIfExists('offers');
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mark_id');
            $table->unsignedBigInteger('car_model_id');
            $table->unsignedBigInteger('generation_id')->nullable();
            $table->Integer('year');
            $table->Integer('run');
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('body_type_id')->nullable();
            $table->unsignedBigInteger('engine_type_id')->nullable();
            $table->unsignedBigInteger('transmission_id')->nullable();
            $table->unsignedBigInteger('gear_type_id')->nullable();
            $table->foreign('mark_id')->references('id')->on('marks')->onDelete('cascade');
            $table->foreign('car_model_id')->references('id')->on('car_models')->onDelete('cascade');
            $table->foreign('generation_id')->references('id')->on('generations')->onDelete('cascade');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade');
            $table->foreign('body_type_id')->references('id')->on('body_types')->onDelete('cascade');
            $table->foreign('engine_type_id')->references('id')->on('engine_types')->onDelete('cascade');
            $table->foreign('transmission_id')->references('id')->on('transmissions')->onDelete('cascade');
            $table->foreign('gear_type_id')->references('id')->on('gear_types')->onDelete('cascade');
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
        Schema::dropIfExists('offers');
    }
};
