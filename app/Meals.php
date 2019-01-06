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
        return $this->hasMany(Orders::class, 'meal_id','id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id','responsible_waiter_id');
    }

    public function Invoices() {
        return $this->belongsTo('Invoices');
    }

}
