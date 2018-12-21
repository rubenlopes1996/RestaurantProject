<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meals extends Model
{

    protected $fillable = [
        //state table respWaiter totalPrice
        'id', 'responsible_waiter_id'
    ];

    public function orders_from_meals(){
        return $this->hasMany('App\Orders');
    }
}
