<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'name', // Aggiunto name
        'web-site', // Aggiunto web-site
        'slug', // Aggiunto slug
    ];
}

