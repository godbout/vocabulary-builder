<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Word extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user_id', function (Builder $builder) {
            $builder->where('user_id', '=', auth()->check() ? auth()->id() : 1);
        });
    }

    public function path()
    {
        return '/words/' . $this->id;
    }

    public function master()
    {
        $this->mastered = 1;
        $this->save();
    }
}
