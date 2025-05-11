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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->integer('department_id');
            $table->integer('program_id');
            $table->string('student_name');
            $table->string('student_id');
            $table->string('year')->nullable();
            $table->string('grade')->nullable();
            $table->string('section');
            $table->time('time')->nullable();
            $table->string('location');
            $table->string('violation_name');
            $table->json('violations')->nullable();
            $table->string('other_violation_name')->nullable();
            $table->text('explain_specify')->nullable();
            $table->text('other_remarks')->nullable();
            $table->string('status')->default('pending');
            $table->text('photo_evidence')->nullable();
            $table->string('guardian_name');
            $table->string('guardian_phone_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
