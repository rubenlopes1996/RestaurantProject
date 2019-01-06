<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
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
            'id' => $this->id,
            'state'=> $this->state,
            '_rowVariant' => ($this->state == 'in preparation' || $this->state == 'pending') ? 'warning' : 'active',
            'item_id' => $this->item_id,
            'meal_id'=>$this->meal_id,
            'responsible_cook_id'=>$this->responsible_cook_id,
            'start'=>$this->start,
            'end'=>$this->end,
            'type'=>$this->item->type,
            
            'responsible_waiter_id'=> $this->meal->responsible_waiter_id

        ];
    }
}
