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
        Schema::create('premium_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('level')->default(1);
            $table->json('features');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('premium_packages');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_premium', 'premium_badge', 'premium_expiration', 'saldo']);
        });
    }
};
