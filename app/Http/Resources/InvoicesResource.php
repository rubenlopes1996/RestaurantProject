<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use App\InvoiceItems;
use App\Meals;
use App\Invoices;
use App\Items;
use App\User;

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
            'id' => $this->id,
            'state' => $this->state,
            'nif' => $this->nif,
            'name' => $this->name,
            'table_number'=> Meals::find($this->meal_id)->table_number,
            'responsible_waiter' => User::find(Meals::find($this->meal_id)->responsible_waiter_id)->name,
            'total_price'=> $this->total_price,
            'date' => $this->date,
            'items_consumed' => Items::find(InvoiceItems::Where('invoice_id', $this->id)->pluck('item_id')),
            'invoice_items' => InvoiceItems::Where('invoice_id', $this->id)->get()
        ];
    }
}
