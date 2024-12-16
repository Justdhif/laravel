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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED by default
            $table->unsignedBigInteger('user_id');
            $table->decimal('total_price', 10, 2);
            $table->integer('discount')->default(0); // Diskon dalam persen (default: 0)
            $table->decimal('final_price', 10, 2);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
