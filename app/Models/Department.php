<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Program;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
      'education_level_name',
      'name',
    ];

    public function programs() {
      return $this->hasMany(Program::class);
    }

    public function reports() {
      return $this->hasMany(Report::class);
    }

   
}
