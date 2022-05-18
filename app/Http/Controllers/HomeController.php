<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
     public function index(){
        $breadcrumb = "Dashboard";
        
        return view('home',compact('breadcrumb'));
     }
}
