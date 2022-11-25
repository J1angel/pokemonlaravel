<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Haters extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pokemon_name',
        'image_link',
    ];

}
