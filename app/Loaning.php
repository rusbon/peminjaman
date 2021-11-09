<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loaning extends Model
{
    public function inventory()
    {
        return $this->belongsTo('App\Inventory');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($loaning) {
            $loaning->name = strtolower($loaning->name);
        });
    }
}
