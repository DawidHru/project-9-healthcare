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
        // database/migrations/xxxx_xx_xx_create_equipment_issues_table.php
        Schema::create('equipment_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('medical_equipment')->onDelete('cascade');
            $table->foreignId('reported_by')->constrained('staff')->onDelete('cascade');
            $table->text('description');
            $table->enum('severity', ['low', 'medium', 'high', 'critical']);
            $table->enum('status', ['reported', 'in_progress', 'resolved', 'closed'])->default('reported');
            $table->text('resolution_notes')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('staff')->onDelete('set null');
            $table->dateTime('resolved_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_issues');
    }
};
