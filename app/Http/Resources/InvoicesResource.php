<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use App\InvoiceItems;


class InvoicesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //state table respWaiter totalPrice
        return [
            'state' => $this->state,
            'table_number'=> $this->table,
            'responsible_waiter'=> $this->responsible_waiter,
            'total_price'=> $this->total_price,
            'name' => $this->name,
            'quantity' => InvoiceItems::Where('invoice_id', $this->meal_id)->get()->count()
    ];
    }
}
