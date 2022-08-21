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
        Schema::dropIfExists('generation_engine_types');
        Schema::create('generation_engine_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('generation_id');
            $table->unsignedBigInteger('engine_type_id');
            $table->foreign('generation_id')->references('id')->on('generations')->onDelete('cascade');
            $table->foreign('engine_type_id')->references('id')->on('engine_types')->onDelete('cascade');
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
        Schema::dropIfExists('generation_engine_types');
    }
};
