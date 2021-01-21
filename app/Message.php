<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'updated_id',
        'payload',
        'replied'
    ];
}
