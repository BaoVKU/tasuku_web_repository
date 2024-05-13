<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAttachment extends Model
{
    use HasFactory;
    protected $fillable = [
        'task_id',
        'name',
        'extension',
        'type',
        'url'
    ];
    public $timestamps = false;

}
