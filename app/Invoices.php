<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    protected $fillable = [
        //state table respWaiter totalPrice
        'state','table_number','responsible_waiter', 'total_price', 'meal_id' , 'name', 'quantity'
    ];
}
