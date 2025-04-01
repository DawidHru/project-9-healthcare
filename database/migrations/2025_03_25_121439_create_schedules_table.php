<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->nullable()->constrained('staff')->onDelete('cascade');
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
