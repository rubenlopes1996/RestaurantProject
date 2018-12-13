<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    protected $fillable = [
        //state table respWaiter totalPrice
        'state', 'nif', 'name', 'table_number','responsible_waiter', 'total_price', 'date', 'items_consumed', 'invoice_items'
    ];

    public function invoices_invoice_items(){
        return $this->hasOne('App\InvoiceItems');
    }
}
