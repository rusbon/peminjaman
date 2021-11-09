<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocSpecific extends Model
{
    protected $table = 'locSpecifics';

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function inventories()
    {
        return $this->hasMany('App\Inventory');
    }
}
