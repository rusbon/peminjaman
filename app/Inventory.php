<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public function locSpecific()
    {
        return $this->belongsTo('App\LocSpecific');
    }

    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    public function loanings()
    {
        return $this->hasMany('App\Loaning');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($inventory) {
            $inventory->name = strtolower($inventory->name);
        });
    }
}
