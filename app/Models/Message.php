<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'channel_id',
        'sender_id',
        'message',
    ];
    public $timestamps = false;
}
