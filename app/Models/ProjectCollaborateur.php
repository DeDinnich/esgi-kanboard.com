<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ProjectCollaborateur extends Model
{
    use HasFactory; // ✅ Ajoute ceci

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['project_id', 'user_id'];
    public $timestamps = false;
}
