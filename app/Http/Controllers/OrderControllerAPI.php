<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\OrdersResource;
use Illuminate\Support\Facades\Auth;
use App\Orders;

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
        ->orWhere('state','confirmed')->where('responsible_cook_id', $id)->Orderby('created_at')->get());
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

    public function prepared($id){
        $order = Orders::findOrFail($id);
        $order->state = 'prepared';
        $order->save();
        dd($order);
        return response()->json(new OrdersResource($order), 200);
    }

    public function inPreparation($id){
        $order = Orders::findOrFail($id);
        $order->state = 'in preparation';
        $order->save();
        return response()->json(new OrdersResource($order), 200);

    }
}
