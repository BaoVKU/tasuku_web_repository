<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageChannel extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_user_id',
        'second_user_id',
        'name'
    ];
    public $timestamps = false;
}
