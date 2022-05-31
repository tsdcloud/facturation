<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerSupportController extends Controller
{

    public function create(){

        $breadcrumb = "support client";

        return view('customer-support', compact('breadcrumb'));
    }

}
