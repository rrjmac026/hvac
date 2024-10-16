<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('appointment_id');
            $table->unsignedBigInteger('pet_id');
            $table->text('notes')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('treatment')->nullable();
            $table->dateTime('visit_date')->nullable(); // Add visit_date column
            $table->string('status')->default('scheduled'); // Add status column
            $table->timestamps();

            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
            $table->foreign('pet_id')->references('id')->on('pets')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->index('appointment_id');
            $table->index('pet_id');
            $table->index('client_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
