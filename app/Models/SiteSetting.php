<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value', 'value_type', 'group', 'label', 'hint'];

    public static function get(string $key, $default = null)
    {
        $row = Cache::remember("site_setting:{$key}", 300, fn () => static::where('key', $key)->first());

        if (! $row) {
            return $default;
        }

        if ($row->value_type === 'image' && $row->value) {
            return Storage::disk('public')->url($row->value);
        }

        if ($row->value_type === 'json') {
            return json_decode($row->value, true);
        }

        return $row->value ?? $default;
    }

    public static function raw(string $key, $default = null)
    {
        $row = static::where('key', $key)->first();

        return $row ? $row->value : $default;
    }

    public static function put(string $key, $value): void
    {
        static::where('key', $key)->update(['value' => $value]);
        Cache::forget("site_setting:{$key}");
    }

    protected static function booted()
    {
        static::saved(fn ($m) => Cache::forget("site_setting:{$m->key}"));
        static::deleted(fn ($m) => Cache::forget("site_setting:{$m->key}"));
    }
}
