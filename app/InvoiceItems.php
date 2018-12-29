<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    protected $fillable = [
        'invoice_id', 'item_id', 'quantity','unit_price','sub_total_price'];

    public function invoices(){
        return $this->belongsTo('App\Invoices');
    }
    public $timestamps = false;
}
