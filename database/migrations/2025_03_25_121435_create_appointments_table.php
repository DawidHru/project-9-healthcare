<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->dateTime('scheduled_time');

            $table->string('reason');
            $table->foreignId('status_id')->constrained('appointment_statuses');
            $table->text('notes')->nullable(); // For additional notes
            $table->enum('confirmation_status', ['pending', 'confirmed', 'cancelled'])->default('pending'); // For confirmation
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
