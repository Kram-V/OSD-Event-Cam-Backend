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
            $table->time('time');
            $table->string('location');
            $table->string('violation_name');
            $table->json('violations')->nullable();
            $table->string('other_violation_name')->nullable();
            $table->text('explain_specify')->nullable();
            $table->text('other_remarks')->nullable();
            $table->text('photo_evidence')->nullable();
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
