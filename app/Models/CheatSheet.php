<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CheatSheet extends Model
{
    protected $table = 'cheat_sheets';

    protected $fillable = [
        'slug',
        'title',
        'description',
        'color',
        'bg',
        'image',
        'topics',
    ];

    // ─── Relationships ────────────────────────────────────────────────

    public function sections(): HasMany
    {
        return $this->hasMany(CheatSheetSection::class, 'cheat_sheet_id')
                    ->orderBy('sort_order');
    }

    public function tags(): HasMany
    {
        return $this->hasMany(CheatSheetTag::class, 'cheat_sheet_id');
    }

    // ─── Helpers ──────────────────────────────────────────────────────

    public function getTagListAttribute(): array
    {
        return $this->tags->pluck('tag')->toArray();
    }
}