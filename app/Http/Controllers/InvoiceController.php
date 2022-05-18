<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;

class InvoiceController extends Controller
{
    public function pdf(){

       // InvoiceService::invoiceBuilder();
    }

    public function index()
    {
        $breadcrumb = "Facturation";
        return view('invoice', compact('breadcrumb'));
    }

    public function myInvoice(){
        $breadcrumb = "Factures";
        $invoices = invoice::paginate(10);

        return view('list-invoices',compact('invoices','breadcrumb'));
    }
}
