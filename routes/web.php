<?php


use App\Models\Weighbridge;
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
Route::get('pdf/{id?}',[InvoiceController::class,'pdf'])->name('show-pdf');
Route::get('ok',[InvoiceController::class, 'pdf']);

Route::middleware(['auth'])->group(function(){

    Route::get('home',[HomeController::class, 'index']);

    Route::get('which-bridge', function (){
        $weighbridges = Weighbridge::all()->reject(function($bridge){

            return $bridge->label == "Direction";
        });

        return view('which-bridge', compact('weighbridges'));
    })->name('bridge');
   // Route::get('which-bridge',[HomeController::class, 'bridge'])->name('bridge');
    Route::get('billing',[InvoiceController::class,'index']);



    Route::get('invoices',[InvoiceController::class, 'myInvoice'])->name('invoices');
    Route::get('bill-pending',[AccountingController::class,'billPending'])->name('bill-pending');
    Route::get('bill/edit/{id}',[AccountingController::class,'edit'])->name('accounting.edit');
    Route::patch('bill/edit/{id}',[AccountingController::class,'update'])->name('accounting.update');
    Route::get('index',[\App\Http\Controllers\ManagingUserController::class, 'index'])->name('account.index');
    Route::get('customer-support', [\App\Http\Controllers\CustomerSupportController::class, 'create'])->name('customer-support');
});

