<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Resources\InvoicesResource;
use \App\Invoices;
use \App\Meals;

class InvoicesControllerAPI extends Controller
{
    public function index(Request $request)
    {
        if($request->has('paid')){
            return InvoicesResource::collection(Invoices::Where('state','paid')->Orderby('created_at')->paginate(15));
        }else if($request->has('pending')) {
            return InvoicesResource::collection(Invoices::Where('state','pending')->Orderby('created_at')->get());
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
