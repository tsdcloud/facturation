<?php

use App\Services\InvoiceService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Invoice;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::middleware(['auth'])->group(function(){

    Route::get('home',[HomeController::class, 'index']);
    Route::get('billing',[InvoiceController::class,'index']);

//    Route::get('pdf/{id}', function ($id) {
//        $data = Invoice::where('id',$id)->first();
//        //dd($data);
//        return InvoiceService::invoiceBuilder($data,'preview');
//    });

    Route::get('pdf/{id?}',[InvoiceController::class,'pdf'])->name('show-pdf');
    Route::get('ok',[InvoiceController::class, 'pdf']);
    Route::get('invoices',[InvoiceController::class, 'myInvoice'])->name('invoices');
});

