<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model {
    use HasFactory;
    protected $fillable = [
        'sender_id',
        'title',
        'description',
    ];
    public $timestamps = false;
}
