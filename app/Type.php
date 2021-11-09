<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public function inventories()
    {
        return $this->hasMany('App\Inventory');
    }
}
