<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('socialite_credentials', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->references('id')->on('users');

            $table->string('email')->nullable();
            $table->boolean('email_verified')->default(false);
            $table->mediumText('access_token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('provider_name')->nullable();
            $table->string('name')->nullable();
            $table->string('nickname')->nullable();

            $table->timestamps();
        });
    }
};
