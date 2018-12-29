<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meals extends Model
{
    protected $fillable = [
        'id', 'state', 'table_number','start','end','responsible_waiter_id','total_price_preview'
    ];
    public function order()
    {
        return $this->hasMany('App\Orders', 'meal_id','id');
    }

}
