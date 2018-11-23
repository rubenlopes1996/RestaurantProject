<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Resources\InvoicesResource;
use \App\Invoices;

class InvoicesControllerAPI extends Controller
{
    public function index()
    {
        return InvoicesResource::collection(Invoices::Where('state','not paid')->Orderby('created_at')->get());
    }
}
//
