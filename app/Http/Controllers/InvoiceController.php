<?php

namespace App\Http\Controllers;

use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;

class InvoiceController extends Controller
{
    public function pdf(){

        InvoiceService::invoiceBuilder();
    }

    public function index(){

        return view('invoice');
    }
}
