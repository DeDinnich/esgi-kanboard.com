<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'user_id', 'column_id', 'nom',
        'description', 'priority', 'order', 'date_limite'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => $model->id ??= (string) Str::uuid());
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function column()
    {
        return $this->belongsTo(Column::class);
    }

    public function collaborateurs()
    {
        return $this->belongsToMany(User::class, 'task_collaborateurs');
    }
}
