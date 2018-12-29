<?php

namespace App\Http\Controllers;

use App\Items;
use App\Meals;
use Illuminate\Http\Request;
use App\Http\Resources\OrdersResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Orders;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Array_;

class OrderControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        
        return OrdersResource::collection(Orders::Where('state','in preparation')->where('responsible_cook_id', $id)
        ->orWhere('state','confirmed')->Orderby('created_at')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function listOrderPendingConfirmed(){
        return OrdersResource::collection(Orders::Where('state','pending')
            ->ORwhere('state','confirmed')
            ->orderBy('id','desc')
            ->paginate(20));
    }
    public function swapOrderToDelivered($id){

        $associatedOrder = Orders::findOrFail($id);
        $itemFromOrder = Items::findOrFail($associatedOrder->item_id);
        $associatedMeal = Meals::findOrFail($associatedOrder->meal_id);
        $associatedMeal->total_price_preview = $associatedMeal->total_price_preview +
                                               $itemFromOrder->price ;
        $associatedMeal->save();
        $associatedOrder->state = 'delivered';
        $associatedOrder->save();
    }

    public function store(Request $request)
    {
        
        $validatedData = $request->validate([

            'meal_id' => 'required|integer|exists:meals,id',
            'items' => 'required|array',
        ]);

        $orders= Collection::make();
        for ($i=0; $i<sizeof($request->items);$i++) {
            $order = new Orders();
            $order->state = "pending";
            $order->item_id = $request->items[$i];
            $order->meal_id = $request->meal_id;
            $order->start = Carbon::now();
            $order->save();
            $orders->push($order);
        }


        return response()->json( OrdersResource::collection($orders), 201);
    }

    public function prepared($id){
        $order = Orders::findOrFail($id);
        $order->state = 'prepared';
        $order->responsible_cook_id = Auth::id();
        $order->save();
        return response()->json(new OrdersResource($order), 200);
    }

    public function inPreparation($id){
        $order = Orders::findOrFail($id);
        $order->state = 'in preparation';
        $order->responsible_cook_id = Auth::id();
        $order->save();
        return response()->json(new OrdersResource($order), 200);
    }
}
