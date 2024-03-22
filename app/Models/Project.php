<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_projects', 'project_id', 'user_id');
    }

    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];
}
