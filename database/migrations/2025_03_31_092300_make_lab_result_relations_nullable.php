<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lab_results', function (Blueprint $table) {
            $table->foreignId('patient_id')->nullable()->change();
            $table->foreignId('doctor_id')->nullable()->change();
            $table->foreignId('lab_technician_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('lab_results', function (Blueprint $table) {
            $table->foreignId('patient_id')->nullable(false)->change();
            $table->foreignId('doctor_id')->nullable(false)->change();
            $table->foreignId('lab_technician_id')->nullable(false)->change();
        });
    }
};
