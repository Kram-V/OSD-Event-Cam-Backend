<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
      'department_id',
      'name',
      'code',
      'description',
    ];

    public function department() {
      return $this->belongsTo(Department::class);
    }
}
