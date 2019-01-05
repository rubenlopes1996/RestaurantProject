<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Resources\InvoicesResource;
use \App\Invoices;
use \App\Meals;
use PDF;
use \App\InvoiceItems;
use \App\Http\Resources\MealsResource;
use \App\Http\Resources\OrdersResource;
use \App\Orders;
use \App\User;
use \App\Items;
use Carbon\Carbon;


class InvoicesControllerAPI extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return InvoicesResource::collection(Invoices::Orderby('created_at')->paginate(10));
        } else if ($request->has('pending')) {
            return InvoicesResource::collection(Invoices::Where('state', 'pending')->Orderby('created_at')->get());
        }
    }

    public function indexPaid(Request $request)
    {
        if ($request->has('page')) {
            return InvoicesResource::collection(Invoices::Where('state', 'paid')->Orderby('id', 'asc')->paginate(10));
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

    public function downloadPDF(Request $request)
    {
        $invoice = Invoices::findOrFail($request->id);
        $items = InvoiceItems::Where('invoice_id', $request->id)->get();
        $responsible_waiter = User::find(Meals::find($invoice->meal_id)->responsible_waiter_id)['name'];
        $nameItem = Items::find(InvoiceItems::Where('invoice_id', $invoice->id)->pluck('item_id'));

        $pdf = PDF::loadView('pdf.PDF', compact('invoice', 'items', 'responsible_waiter', 'nameItem'));
        $filename = base_path($invoice->name . $invoice->id . '.pdf');
        $pdf->save($filename);
        return \Response::download($filename);
    }

    public function store($id)
    {
        $meal = Meals::findOrfail($id);

        $invoice = new Invoices();
        $invoice->state = 'pending';
        $invoice->total_price = $meal->total_price_preview;
        $invoice->meal_id = $id;
        $invoice->date = Carbon::now()->toDateString();
        $invoice->save();

        $orders = Orders::where('state', 'delivered')->where('meal_id', $meal->id)->get();

        $items = [];
        foreach ($orders as $order) {
            if (!in_array($order->item_id, $items)) {
                $invoiceItem = new InvoiceItems();
                $aux = 0;
                foreach ($orders as $orderAux) {
                    if ($order->item_id == $orderAux->item_id) {
                        $aux += 1;
                    }
                }
                $invoiceItem->invoice_id = $invoice->id;
                $invoiceItem->item_id = $order->item_id;
                $invoiceItem->quantity = $aux;
                $invoiceItem->unit_price = $order->item->price;
                $invoiceItem->sub_total_price = $aux * $order->item->price;
                $invoiceItem->save();
                $items[] = $invoiceItem->item_id;
            }
        }
        return response()->json(new InvoicesResource($invoice), 201);
    }

    public function listInvoicesPending()
    {
        return InvoicesResource::collection(Invoices::Where('state', 'pending')->paginate(10));
    }

    public function listInvoicesDate($date,$toDate ){

        return InvoicesResource::collection(Invoices::whereBetween('date', array($date,$toDate))->paginate(10));
    }
    public function listInvoicesPaidOrNotPaid($data)
    {

        return InvoicesResource::collection(Invoices::where('state', $data)->paginate(10));

//        dd( InvoicesResource::collection(Invoices::with(['meal'=> function ($q) {
//        $q->orderBy('responsible_waiter_id', 'des');}])->paginate(2)));
//
        //$data = InvoicesResource::collection(Invoices::with(['meal'=> function ($q) {
          //  $q->orderBy('responsible_waiter_id', 'des');}])->paginate(2));

      //  return $data->sortByDesc('meal.responsible_waiter_id');








    }



}

