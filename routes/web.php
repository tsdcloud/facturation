<?php


use App\Http\Controllers\StampController;
use App\Models\Weighbridge;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\SignatureController;

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
Route::get('display/{id?}',[InvoiceController::class,'pdf'])->name('show-pdf');
Route::get('print/receipt',[InvoiceController::class, 'pdf']);

Route::middleware(['auth'])->group(function(){

    Route::get('home',[HomeController::class, 'index'])->name('home');

    Route::get('which-bridge', function (){
        $weighbridges = Weighbridge::all()->reject(function($bridge){

            return $bridge->label == "Direction";
        });

        return view('which-bridge', compact('weighbridges'));
    })->name('bridge');
    Route::get('report',[HomeController::class, 'report'])->name('report');
    Route::get('billing',[InvoiceController::class,'index']);



    Route::get('invoices',[InvoiceController::class, 'myInvoice'])->name('invoices');
    Route::get('all-invoices',[InvoiceController::class, 'allInvoice'])->name('allInvoice');
    Route::get('bill-pending',[AccountingController::class,'billPending'])->name('bill-pending');
    Route::get('bill/edit/{id}',[AccountingController::class,'edit'])->name('accounting.edit');
    Route::patch('bill/edit/{id}',[AccountingController::class,'update'])->name('accounting.update');
    Route::get('index',[\App\Http\Controllers\ManagingUserController::class, 'index'])->name('account.index');
    Route::get('customer-support', [\App\Http\Controllers\CustomerSupportController::class, 'create'])->name('customer-support');

    //route add stamp

    Route::get('stamp/index',[StampController::class, 'index'])->name('stamp.index');
    Route::get('stamp/create',[StampController::class, 'create'])->name('stamp.create');
    Route::post('stamp/store',[StampController::class, 'store'])->name('stamp.store');

    //route add signature

    Route::resource('signature',SignatureController::class);
});

