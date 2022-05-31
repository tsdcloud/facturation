<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AccountingController;

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

    Route::get('pdf/{id?}',[InvoiceController::class,'pdf'])->name('show-pdf');
    Route::get('ok',[InvoiceController::class, 'pdf']);
    Route::get('invoices',[InvoiceController::class, 'myInvoice'])->name('invoices');
    Route::get('bill-pending',[AccountingController::class,'billPending'])->name('bill-pending');
    Route::get('index',[\App\Http\Controllers\ManagingUsers::class,'index'])->name('account.index');
    Route::get('customer-support', [\App\Http\Livewire\Invoice\CustomerSupport::class, 'index'])->name('customer-support');
});

