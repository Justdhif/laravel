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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_code')->unique();
            $table->integer('discount')->comment('Discount in percentage');
            $table->date('expiry_date');
            $table->enum('type', ['general', 'specific']);
            $table->foreignId('menu_id')->constrained('menus')->nullable()->onDelete('cascade');
            $table->unsignedBigInteger('menu_id')->nullable()->change();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_id')->nullable(false)->change();
        });
    }
};
