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

        static::addGlobalScope('search', function (Builder $builder) {
            if (request()->has('search')) {
                $term = request()->input('search');
                $builder->where(function ($builder) use ($term) {
                    $builder->where('spelling', 'LIKE', '%' . $term . '%')
                        ->orWhere('excerpt', 'LIKE', '%' . $term . '%');
                });
            }
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
