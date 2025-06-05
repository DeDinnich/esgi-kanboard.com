<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'user_id', 'nom'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => $model->id ??= (string) Str::uuid());
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function columns()
    {
        return $this->hasMany(Column::class);
    }

    public function collaborateurs()
    {
        return $this->belongsToMany(User::class, 'project_collaborateurs');
    }
}
