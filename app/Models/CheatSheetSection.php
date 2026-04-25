<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CheatSheetSection extends Model
{
    protected $table = 'cheat_sheet_sections';

    protected $fillable = [
        'cheat_sheet_id',
        'title',
        'note',
        'sort_order',
    ];

    // ─── Relationships ────────────────────────────────────────────────

    public function cheatSheet(): BelongsTo
    {
        return $this->belongsTo(CheatSheet::class, 'cheat_sheet_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(CheatSheetItem::class, 'section_id')
                    ->orderBy('sort_order');
    }
}