<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('photo')->nullable(); // Add this line
            $table->string('species');
            $table->string('breed');
            $table->text('medical_history')->nullable();
            $table->text('allergies')->nullable();
            $table->text('vaccinations')->nullable();
            $table->text('ongoing_treatments')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pets');
    }
}

