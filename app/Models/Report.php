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
      'time',
      'location',
      'violation_name',
      'violations',
      'other_violation_name',
      'explain_specify',
      'other_remarks',
      'photo_evidence',
    ];
}
