<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentAttachment extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment_id',
        'name',
        'extension',
        'type',
        'url'
    ];
    public $timestamps = false;
}
