<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;

class InvoiceController extends Controller
{
    public function pdf(){
        $pdf = Pdf::loadView('viewPdf');
        return $pdf->download();
    }

    public function index(){

        return view('invoice');
    }
}
