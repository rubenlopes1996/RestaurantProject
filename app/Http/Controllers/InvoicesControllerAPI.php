<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Resources\InvoicesResource;
use \App\Invoices;
use \App\Meals;

use \App\Http\Resources\MealsResource;
use \App\Http\Resources\OrdersResource;
use \App\Orders;

class InvoicesControllerAPI extends Controller
{
    public function index(Request $request)
    {
        if($request->has('page')){
            return InvoicesResource::collection(Invoices::Orderby('created_at')->paginate(10));
        }else if($request->has('pending')) {
            return InvoicesResource::collection(Invoices::Where('state','pending')->Orderby('created_at')->get());
            //$id = 7;
            //return Meals::Where('responsible_waiter_id',$id)->pluck('id');
            //return Orders::Where('state','prepared')->WhereIn('meal_id', Meals::Where('responsible_waiter_id',$id)->pluck('id'))->get();
            //return Orders::Where('state','prepared')->get();
        }
    }

    public function indexPaid(Request $request)
    {
        if ($request->has('page')) {
            return InvoicesResource::collection(Invoices::Where('state','paid')->Orderby('id', 'asc')->paginate(10));
        }
    }

    public function show($id)
    {
        return new InvoicesResource(Invoices::find($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nif' => 'required|min:9|max:9',
            'name' => 'required|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
        ]);

        $invoice = Invoices::findOrFail($id);
        $invoice->nif = $data['nif'];
        $invoice->name = $data['name'];
        //$invoice->responsible_waiter = $data['responsible_waiter'];
        $invoice->state = 'paid';
        //TODO, meals para testar
        Meals::findOrFail($invoice->meal_id)->state = 'paid';
        $invoice->save();
        return new InvoicesResource($invoice);
    }

}
//
