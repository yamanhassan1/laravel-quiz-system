<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MCQ_Record extends Model
{

    protected $fillable = [
        'record_id',
        'user_id',
        'mcq_id',
        'select_answer',
        'is_correct',
    ];
    
    //
    protected $table = 'mcq_records';
    public function mcq()
    {
        return $this->belongsTo(MCQ::class, 'mcq_id');
    }
 
    // Scope used in result page: MCQ_Record::withMCQ()->where(...)->get()
    public function scopeWithMCQ($query)
    {
        return $query->with('mcq');
    }

}
