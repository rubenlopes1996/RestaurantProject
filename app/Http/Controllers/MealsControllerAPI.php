<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrdersResource;
use App\RestaurantTable;
use Illuminate\Http\Request;
use \App\Http\Resources\MealsResource;
use \App\Meals;
use Carbon\Carbon;
use \App\Orders;
use \App\Http\Resources\MealsWithOrdersResource;
use App\Invoices;

class MealsControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MealsResource::collection(Meals::all());
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
    public function showMealsWithPreparedOrders($id)
    {
        return Orders::Where('state', 'prepared')
            ->WhereIn('meal_id', Meals::
            Where('responsible_waiter_id', $id)->
            pluck('id'))->get();
    }

    public function terminatedMeals($id){
        $meal =Meals::findOrFail($id);
        $meal->state='terminated';
        $meal->end=Carbon::now();
        $meal->save();
        $orders = Orders::where('meal_id', $id) ->where('state','!=','delivered') ->get();

        foreach ($orders as $order){ 
            $order->state = 'not delivered';
            $order->save();
        }

    }


    public function showMealsById($id)
    {

        return MealsResource::collection(Meals::where('responsible_waiter_id', $id)
            ->where('state', 'active')
            ->get());
    }

    public function store(Request $request, $id)
    {
        $table = RestaurantTable::where('table_number', $request->table_number)->get();
        if(count($table)!=0) {

            $meals = Meals::where('table_number', $request->table_number)
                ->where('state', 'active')->get();
            if (count($meals) == 0) {

                $validatedData = $request->validate([

                    'table_number' => 'required|integer',

                ]);


                $meal = new Meals();
                $meal->state = 'active';
                $meal->start = Carbon::now();
                $meal->responsible_waiter_id = $id;
                $meal->table_number = $validatedData['table_number'];
                $meal->save();
                return response()->json(new MealsResource($meal), 201);
            }
            return response()->json("Meal is already active!", 403);

        }
        else {
            return response()->json("Table does not exist!", 404);
        }
    }
    public function showSummaryMeals($id)
    {
        return MealsWithOrdersResource::collection(Meals::where('responsible_waiter_id', $id)->OrderBy('id','des')->paginate(20));
    }

    public function listmealsManager(){
        return MealsResource::collection(Meals::Where('state','active')->OrWhere('state','terminated')->orderBy('id','desc')->paginate(10));

    }
    public function listmealsManagerSummary(){
        return MealsWithOrdersResource::collection(Meals::Where('state','!=','empty')->paginate(10));

    }

    public function listMeals($state)
    {

        if ($state == 'active') {
            return MealsResource::collection(Meals::where('state', 'active')->paginate(10));
        } elseif ($state == 'terminated') {
            return MealsResource::collection(Meals::where('state', 'terminated')->paginate(10));
        } elseif ($state == 'not paid') {
            return MealsResource::collection(Meals::where('state', 'not paid')->paginate(10));
        } elseif ($state == 'paid') {
            return MealsResource::collection(Meals::where('state', 'paid')->paginate(10));
        } elseif ($state == 'start') {
            return MealsResource::collection(Meals::orderBY('start')->paginate(10));
        } elseif ($state == 'responsible_waiter_id') {
            return MealsResource::collection(Meals::orderBY('responsible_waiter_id')->paginate(10));
        }
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


    public function notPaid($id){
        $meal = Meals::findOrFail($id);
        $meal->state = "not paid";
        $meal->end = Carbon::now();
        
        $invoice = Invoices::where('meal_id',$meal_id);
        $invoice->state = "not paid";

        $orders = Orders::Where('meal_id',$meal->id);
        foreach($orders as $order){
            if($order->state != 'delivered'){
                $order->state = "not delivered";
            }
            $order->end = Carbon::now();
            $order->save();
        }

        $meal->save();
        $invoice->save();

    }


}
