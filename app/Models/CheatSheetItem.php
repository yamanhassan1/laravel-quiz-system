<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheatSheetItem extends Model
{
    protected $table = 'cheat_sheet_items';

    protected $fillable = [
        'section_id',
        'label',
        'code',
        'note',
        'sort_order',
    ];

    // ─── Relationships ────────────────────────────────────────────────

    public function section(): BelongsTo
    {
        return $this->belongsTo(CheatSheetSection::class, 'section_id');
    }
}