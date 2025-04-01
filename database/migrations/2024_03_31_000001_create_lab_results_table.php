<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lab_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('lab_technician_id')->constrained('lab_technicians')->onDelete('cascade');
            $table->string('test_name');
            $table->string('test_category');
            $table->text('result_value');
            $table->text('reference_range')->nullable();
            $table->boolean('is_abnormal')->default(false);
            $table->text('doctor_notes')->nullable();
            $table->text('interpretation')->nullable();
            $table->enum('status', ['pending', 'completed', 'reviewed'])->default('pending');
            $table->timestamp('test_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lab_results');
    }
};
