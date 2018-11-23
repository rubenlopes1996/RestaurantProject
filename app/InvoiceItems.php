<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    public function invoices(){
        return $this->belongsTo('App\Invoices');
    }
}
