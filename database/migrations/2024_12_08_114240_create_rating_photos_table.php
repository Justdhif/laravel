<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('rating_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ratings_id');
            $table->string('path');
            $table->timestamps();

            $table->foreign('ratings_id')->references('id')->on('ratings')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rating_photos');
    }
};
