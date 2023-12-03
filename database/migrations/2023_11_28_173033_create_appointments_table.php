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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('booking_time');
            $table->decimal('doctor_fee_amount', 10, 2);
            $table->decimal('admin_fee_amount', 10, 2);
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('doctor_id');
            // $table->foreignId('client_id')->constrained(table: 'users', indexName: 'appointments_doctor_id');
            // $table->foreignId('doctor_id')->constrained(table: 'users', indexName: 'appointments_doctor_id');
            $table->foreign('client_id')->references('id')->on('users')->onUpdate('cascade')
            ->onDelete('cascade');
            
            $table->foreign('doctor_id')->references('id')->on('users')->onUpdate('cascade')
            ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
