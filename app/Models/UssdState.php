<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UssdState extends Model
{
    use HasFactory;

    protected $fillable = [
        "session", "ussd_product", "screen_path"
    ];

    protected $casts = [
        "screen_path" => "array"
    ];
}
