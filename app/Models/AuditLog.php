<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'audit_log';
    public $timestamps = false;

    protected $fillable = [
        'event_code', 'severity', 'actor', 'ip_address', 'ref_table', 'ref_id', 'message', 'meta',
    ];

    protected $casts = ['meta' => 'array'];
}
