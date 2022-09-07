<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class CheckpointController extends Controller
{
    public function index(){
        $breadcrumb = "Contrôle camion";
        return view('checkpoint.index',compact('breadcrumb'));
    }

    public function edit(Invoice $invoice){

        $invoice = Invoice::where('id',$invoice->id)->first();

        if (is_null($invoice))
           throw new \Exception;

        $breadcrumb = "Détails";
        return view('checkpoint.create',compact('breadcrumb','invoice'));
    }

    public function store(Request $request ,Invoice $invoice){

    }
}
