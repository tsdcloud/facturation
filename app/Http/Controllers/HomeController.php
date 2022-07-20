<?php

namespace App\Http\Controllers;


use App\Models\Invoice;


class HomeController extends Controller
{
     public function index(){
        $breadcrumb = "Dashboard";
        $total_amount_month = Invoice::where('status_invoice','validated')->sum('total_amount');
        $number_invoices = Invoice::count();
        $cancelled_invoice = Invoice::where('status_invoice','cancelling')->count();
        $amount_cancelled_invoice = Invoice::where('status_invoice','cancelling')
                                             ->sum('total_amount');
        return view('home',compact('breadcrumb','total_amount_month','number_invoices','cancelled_invoice','amount_cancelled_invoice'));
     }

     public function bridge(){

         return view('which-bridge');
     }

     public function report(){

         $breadcrumb = "Etat facturation";
         return view('report',compact('breadcrumb'));
     }
}
