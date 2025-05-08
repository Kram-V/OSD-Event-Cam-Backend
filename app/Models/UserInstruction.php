<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInstruction extends Model
{
    use HasFactory;

    protected $fillable = [
      'instruction_name',
      'description',
    ];
}
