<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhisperMessage extends Model
{
    use HasFactory;

    protected $table = 'chat_whisper';

    protected $fillable = [
        'sender_id',
        'sender_name',
        'receiver_id',
        'receiver_name',
        'message',
    ];
}
