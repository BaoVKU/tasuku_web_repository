<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailAttachment extends Model {
    use HasFactory;
    protected $fillable = [
        'email_id',
        'name',
        'extension',
        'type',
        'url'
    ];
    public $timestamps = false;
}
