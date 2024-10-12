<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // Link to Client
            $table->foreignId('pet_id')->constrained()->onDelete('cascade'); // Link to Pet
            $table->dateTime('appointment_date'); // Date and time of the appointment
            $table->string('status')->default('scheduled'); // Status of the appointment (e.g., scheduled, completed, canceled)
            $table->text('notes')->nullable(); // Optional notes about the appointment
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}

