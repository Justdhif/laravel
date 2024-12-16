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
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('menu_id');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();

            // Foreign keys
            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions')
                ->onDelete('cascade');

            $table->foreign('menu_id')
                ->references('id')
                ->on('menus')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropColumn('voucher_id');
        });
    }
};
