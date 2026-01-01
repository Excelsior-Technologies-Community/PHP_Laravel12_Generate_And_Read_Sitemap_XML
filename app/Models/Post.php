<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Table name (optional, Laravel auto-detects)
    protected $table = 'posts';

    // Mass assignable fields
    protected $fillable = [
        'title',
        'slug',
        'body',
    ];
}
