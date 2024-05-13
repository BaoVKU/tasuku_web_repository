<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskOperation extends Model
{
    use HasFactory;
    protected $fillable = [
        'task_id',
        'user_id',
        'is_completed',
        'is_important'
    ];
    public $timestamps = false;
}
