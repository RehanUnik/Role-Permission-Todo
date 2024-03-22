<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    use HasFactory;
    protected $fillable = [
        'task_id',
        'to_status',
        'status_change_date',
        'from_status',
        'modify_user_id',
    ];
}
