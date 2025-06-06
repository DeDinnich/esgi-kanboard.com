<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ProjectInvitation extends Model
{
    use HasFactory;

    // ID auto-incrémenté, donc on laisse le comportement par défaut
    protected $fillable = [
        'project_id',
        'user_id',
        'token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->token) {
                $model->token = Str::random(40);
            }
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
