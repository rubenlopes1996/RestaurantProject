<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'state', 'item_id','meal_id','responsible_cook_id','start','end'
    ];

    public function item(){
        return $this->hasOne(Items::class,'id','item_id');
    }

    public function meal(){
        return $this->hasOne(Meals::class, 'id', 'meal_id');
    }

}
