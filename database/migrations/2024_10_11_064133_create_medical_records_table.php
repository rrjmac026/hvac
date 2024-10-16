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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pet_id')->constrained()->onDelete('cascade'); // Assuming you have a pets table
            $table->date('date'); // The date of the record
            $table->text('treatment')->nullable(); // Treatment details
            $table->text('surgery')->nullable(); // Surgery details
            $table->text('medication')->nullable(); // Medication details
            $table->text('lab_results')->nullable(); // Lab results
            $table->date('next_appointment_date')->nullable(); // Next appointment date
            $table->timestamps(); // Laravel's created_at and updated_at timestamps
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
