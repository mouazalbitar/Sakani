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
            // $table->foreignId('city_id')->constrained('cities', 'id');
            $table->string('street');
            $table->double('price')->unsigned();
            $table->integer('rooms')->unsigned()->default(1);
            $table->integer('size')->unsigned();
            $table->enum('condition', ['deluxe', 'new', 'normal']);
            $table->enum('is_approved', ['approved', 'rejected', 'waiting'])->default('waiting');
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
