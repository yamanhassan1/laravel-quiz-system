<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class quiz extends Model
{
    //
    function category(){
        return $this->belongsTo(Category::class);
    }

    function Mcqs(){
        return $this->hasMany(Mcq::class);
    }

    function Records(){
        return $this->hasMany(Record::class);
    }

    public function getAttemptsCountAttribute()
    {
        return $this->records()->count();
    }
    
    // Get average score for this quiz
    public function getAverageScoreAttribute()
    {
        return round($this->records()->avg('score') ?? 0);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'user_favorites', 'quiz_id', 'user_id');
    }
}
