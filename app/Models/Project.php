<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $timestamps = false;
    protected $table = 'projects';
    protected $guarded = [];

    public function scopeVisible($query)
    {
        return $query->where('is_visible', 1);
    }

    public function getTagsArrayAttribute(): array
    {
        return $this->tags
            ? array_map('trim', explode(',', $this->tags))
            : [];
    }

    public function getStackArrayAttribute(): array
    {
        return $this->stack
            ? array_map('trim', explode(',', $this->stack))
            : [];
    }
}
