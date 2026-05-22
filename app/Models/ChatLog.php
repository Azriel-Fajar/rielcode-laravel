<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_message', 'bot_reply', 'tag', 'ip_address', 'input_tokens', 'output_tokens',
    ];
}
