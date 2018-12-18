<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RestaurantTable;
use App\Http\Resources\RestaurantTableResource;
use App\EloquentVueTables;

class RestaurantTableAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return RestaurantTableResource::collection(RestaurantTable::paginate(5));
        } else {
            return RestaurantTableResource::collection(RestaurantTable::all());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            'table_number' => 'required|unique:restaurant_tables,table_number'
        ]);

        $table = new RestaurantTable();
        $table->table_number = $data['table_number'];
        $table->save();
        return response()->json(new RestaurantTableResource($table), 201);

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
        $table = RestaurantTable::where('table_number',$id);
        $table = $table->delete();
        return response()->json(null, 204);
    }
}
