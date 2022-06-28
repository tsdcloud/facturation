<?php

namespace App\Http\Controllers;


use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function pdf($id){

        $data = Invoice::where('id',$id)->first();

       InvoiceService::invoiceBuilder($data,'preview');
    }

    public function index()
    {
        $breadcrumb = "Facturation";
        return view('invoice', compact('breadcrumb'));
    }

    public function myInvoice(){

        $breadcrumb = "liste factures";
        $invoices = Invoice::where('user_id', Auth::user()->id)->paginate(10);

        if(Auth::user()->isAdmin() || Auth::user()->isAdministration() ){
            $invoices = Invoice::paginate(10);
            return view('list-invoice',compact('invoices','breadcrumb'));
        }

        return view('list-invoice',compact('invoices','breadcrumb'));
    }

    public function allInvoice(){
        $breadcrumb = "liste factures";
        $invoices = Invoice::orderBy('created_at','DESC')->paginate(10);
        return view('list-invoice2',compact('invoices','breadcrumb'));
    }
}
