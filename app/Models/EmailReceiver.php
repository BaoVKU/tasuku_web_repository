<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailReceiver extends Model {
    use HasFactory;
    protected $fillable = [
        'email_id',
        'receiver_id'
    ];
    public $timestamps = false;
}
