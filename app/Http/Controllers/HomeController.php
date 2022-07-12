<?php

namespace App\Http\Controllers;


use App\Models\Invoice;


class HomeController extends Controller
{
     public function index(){
        $breadcrumb = "Dashboard";
        $total_amount_month = Invoice::sum('total_amount');
        $number_invoices = Invoice::count();
        $cancelled_invoice = Invoice::where('status_invoice','cancelling')->count();
        return view('home',compact('breadcrumb','total_amount_month','number_invoices','cancelled_invoice'));
     }

     public function bridge(){

         return view('which-bridge');
     }

     public function report(){

         $breadcrumb = "Etat facturation";
         return view('report',compact('breadcrumb'));
     }
}
