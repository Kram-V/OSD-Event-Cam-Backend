<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
      'department_id',
      'program_id',
      'student_name',
      'student_id',
      'year',
      'time',
      'location',
      'violation_name',
      'violations',
      'other_violation_name',
      'explain_specify',
      'other_remarks',
      'status',
      'photo_evidence',
      'guardian_name',
      'guardian_phone_number',
    ];

    public function department() {
      return $this->belongsTo(Department::class);
    }

    public function program() {
      return $this->belongsTo(Program::class);
    }
}
