<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apertment_id')->constrained('apartments', 'id');
            $table->foreignId('tenant_id')->constrained('users', 'id');
            $table->date('start');
            $table->date('end');
            $table->string('payment_details')->nullable();
            $table->enum('booking_status', [
                'approved',
                'canceled',
                'pending'
            ])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
