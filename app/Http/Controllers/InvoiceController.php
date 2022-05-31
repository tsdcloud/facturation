<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function pdf($id){

        $data = invoice::where('id',$id)->first();

       InvoiceService::invoiceBuilder($data,'preview');
    }

    public function index()
    {
        $breadcrumb = "Facturation";
        return view('invoice', compact('breadcrumb'));
    }

    public function myInvoice(){

        $breadcrumb = "Factures";
        $invoices = invoice::where('user_id', Auth::user()->id)->paginate(10);
        return view('list-invoice',compact('invoices','breadcrumb'));
    }
}
