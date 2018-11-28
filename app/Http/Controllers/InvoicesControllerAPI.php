<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Resources\InvoicesResource;
use \App\Invoices;

class InvoicesControllerAPI extends Controller
{
    public function index(Request $request)
    {
        if($request->has('paid')){
            return InvoicesResource::collection(Invoices::Where('state','paid')->Orderby('created_at')->get());
        }else if($request->has('unpaid')) {
            return InvoicesResource::collection(Invoices::Where('state','not paid')->Orderby('created_at')->get());
        }
    }
}
//
