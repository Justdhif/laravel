<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->decimal('saldo', 15, 2)->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('role')->default('pembeli');
            $table->string('profile_pic')->nullable();
            $table->text('bio')->nullable();
            $table->string('password');
            $table->boolean('is_premium')->default(false);
            $table->string('premium_badge')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', callback: function (Blueprint $table) {
            $table->dropColumn(['saldo', 'role', 'profile_pic', 'bio', 'premium_badge']);
        });
    }
};
