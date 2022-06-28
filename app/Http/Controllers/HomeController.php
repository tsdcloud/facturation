<?php

namespace App\Http\Controllers;


use App\Models\Invoice;


class HomeController extends Controller
{
     public function index(){
        $breadcrumb = "Dashboard";
        $total_amount_month = Invoice::sum('total_amount');

        return view('home',compact('breadcrumb','total_amount_month'));
     }

     public function bridge(){

         return view('which-bridge');
     }

     public function report(){

         $breadcrumb = "Etat facturation";
         return view('report',compact('breadcrumb'));
     }
}
