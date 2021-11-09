<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function locSpecifics()
    {
        return $this->hasMany('App\LocSpecific');
    }
}
