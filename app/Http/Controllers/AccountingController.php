<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use Illuminate\Http\Request;

class AccountingController extends Controller
{

    public function billPending(){

        $breadcrumb = "Facture en attente";
        $invoices = invoice::where('approved', 'pending')->get();

        return view('account.bill-pending',compact('invoices','breadcrumb'));
    }

}
