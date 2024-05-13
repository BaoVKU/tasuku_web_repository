<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'creator_id',
        'group_id',
        'mode',
        'title',
        'description',
        'start',
        'end'
    ];
    public $timestamps = false;
}
