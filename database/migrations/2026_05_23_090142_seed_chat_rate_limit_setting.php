<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('site_settings')->insertOrIgnore([
            'key'        => 'chat.rate_limit_enabled',
            'value'      => '1',
            'value_type' => 'string',
            'group'      => 'Chat',
            'label'      => 'Enable Chat Rate Limiting',
            'hint'       => 'Set to 0 to disable all chat rate limits (hourly, daily, token). Useful for demos or testing.',
        ]);
    }

    public function down(): void
    {
        DB::table('site_settings')->where('key', 'chat.rate_limit_enabled')->delete();
    }
};
