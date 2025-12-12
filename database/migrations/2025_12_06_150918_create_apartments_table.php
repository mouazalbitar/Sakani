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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users', 'id');
            $table->string('governorate');
            $table->foreignId('city_id')->constrained('cities', 'id');
            $table->string('street');
            $table->double('price');
            $table->integer('rooms');
            $table->integer('size');
            $table->enum('condition', ['deluxe', 'new', 'normal']);
            $table->text('details')->nullable();
            $table->string('img1')->nullable();
            $table->string('img2')->nullable();
            $table->string('img3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
