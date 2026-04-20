<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class quiz extends Model
{
    //
    function category(){
        return $this->belongsTo(Category::class);
    }

    function mcqs(){
        return $this->hasMany(Mcq::class);
    }
}
