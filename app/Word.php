<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $guarded = [];
    
    public function path()
    {
        return '/words/' . $this->id;
    }
}
