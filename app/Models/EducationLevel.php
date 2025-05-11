<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationLevel extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
    ];

    public function departments() {
      return $this->hasMany(Department::class);
    }

    public function reports() {
      return $this->hasMany(Report::class);
    }
}
