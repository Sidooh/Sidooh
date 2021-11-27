<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UssdVars extends Model
{
    use HasFactory;

    protected $fillable = [
        "session", "vars"
    ];

    protected $casts = [
        "vars" => "array"
    ];
}
