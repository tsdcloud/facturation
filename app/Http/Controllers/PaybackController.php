<?php

namespace App\Http\Controllers;


use App\Models\Invoice;
use Illuminate\Http\Request;

class PaybackController extends Controller
{
    public function index(){

        $breadcrumb = "Remboursements";
        $refunds = Invoice::where('isRefunded',false)->paginate(10);
        return view('payback.index',compact('breadcrumb','refunds'));
    }

    public function edit($id){

        $breadcrumb = "Modifie la facture";
        $invoice = Invoice::where('id',$id)->first();

        return view('payback.edit',compact('breadcrumb','invoice'));
    }

    public function update(Request $request, Invoice $invoice){

    if($request->isRefunded == "on"){
        tap($invoice)->update([
            'isRefunded' => true,
            'who_paid_back' => auth()->user()->name,
            'who_paid_back_id' => auth()->user()->id
            ]);

        return to_route('payback.index')->with('succès','facture remboursée : opération reussite');
    }
    return  to_route('payback.index');
    }
}
