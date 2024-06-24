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
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone');
            $table->enum('status', ['active', 'pending', 'review', 'closed'])->default('pending');
            $table->rememberToken();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string('country')->nullable();
            $table->string('country_iso2_code')->nullable();
            $table->string('country_iso3_code')->nullable();
            $table->string('state')->nullable();
            $table->string('currency')->nullable();
            $table->string('locale')->nullable();
            $table->timestamps();

            $table->index('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
