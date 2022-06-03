<?php

namespace App\Http\Controllers;

use App\Models\Weighbridge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
     public function index(){
        $breadcrumb = "Dashboard";

//        if (Auth::check()){
//            if (Auth::user()->role == "user"){
//
//                return redirect()->route('bridge');
//            }
//        }

        return view('home',compact('breadcrumb'));
     }

     public function bridge(){

         return view('which-bridge');
     }
}
