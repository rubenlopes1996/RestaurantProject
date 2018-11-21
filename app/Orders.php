<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'state', 'item_id','meal_id','responsible_cook_id','start','end'
    ];

}
