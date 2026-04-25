<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheatSheetTag extends Model
{
    protected $table = 'cheat_sheet_tags';

    protected $fillable = [
        'cheat_sheet_id',
        'tag',
    ];

    // ─── Relationships ────────────────────────────────────────────────

    public function cheatSheet(): BelongsTo
    {
        return $this->belongsTo(CheatSheet::class, 'cheat_sheet_id');
    }
}