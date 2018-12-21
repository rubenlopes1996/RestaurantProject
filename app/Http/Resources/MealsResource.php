<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Orders;

class MealsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            //'table_number'=> Meals::find($this->meal_id)->table_number,
            //'responsible_waiter' => User::find(Meals::find($this->meal_id)->responsible_waiter_id)->name,
            'orders' => Orders::find($this->id)->get()
            //'items_consumed' => Items::find(InvoiceItems::Where('invoice_id', $this->id)->pluck('item_id')),
            //'invoice_items' => InvoiceItems::Where('invoice_id', $this->id)->get()
        ];
    }
}
