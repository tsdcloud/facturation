<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\Weighbridge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
     public function index(){
        $breadcrumb = "Dashboard";
        $total_amount_month = invoice::sum('total_amount');

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
