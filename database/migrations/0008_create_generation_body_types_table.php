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
        Schema::dropIfExists('generation_body_types');
        Schema::create('generation_body_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('generation_id');
            $table->unsignedBigInteger('body_type_id');
            $table->foreign('generation_id')->references('id')->on('generations')->onDelete('cascade');
            $table->foreign('body_type_id')->references('id')->on('body_types')->onDelete('cascade');
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
        Schema::dropIfExists('generation_body_types');
    }
};
