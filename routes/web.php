<?php


use App\Http\Controllers\PaybackController;
use App\Http\Controllers\StampController;
use App\Http\Controllers\UserController;
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

//route pour afficher la facture sans coupon et la télécherger depuis l'exterieur
Route::get('display/{id?}',[InvoiceController::class,'pdf'])->name('show-pdf');

// route pour afficher la facture avec coupon de remboursement
Route::get('coupon/{id?}',[InvoiceController::class,'pdfWithCoupon'])->name('show-coupon');


Route::get('export',[InvoiceController::class,'exportCG'])->name('export-cg');


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
    Route::get('refund',[InvoiceController::class, 'refund'])->name('refund');
    Route::get('export',[InvoiceController::class, 'export'])->name('export');
    Route::get('bill-pending',[AccountingController::class,'billPending'])->name('bill-pending');
    Route::get('bill/edit/{id}',[AccountingController::class,'edit'])->name('accounting.edit');
    Route::patch('bill/edit/{id}',[AccountingController::class,'update'])->name('accounting.update');
  //  Route::get('index',[\App\Http\Controllers\ManagingUserController::class, 'index'])->name('account.index');
    Route::get('customer-support', [\App\Http\Controllers\CustomerSupportController::class, 'create'])->name('customer-support');

    //route add stamp
    Route::resource('stamp',StampController::class);
    //route add signature
    Route::resource('signature',SignatureController::class);

    Route::resource('account',UserController::class);
    Route::get('payback/index',[PaybackController::class,'index'] )->name('payback.index');
    Route::get('payback/edit/{id}',[PaybackController::class,'edit'] )->name('payback.edit');
    Route::patch('payback/update/{invoice}',[PaybackController::class,'update'] )->name('payback.update');
    Route::patch('reset/{id}',[UserController::class,'resetPassword'])->name('reset.password');
    //journal d'erreur
    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->name('log');

    Route::get('/checkpoint/index', function(){
        $breadcrumb = "Contrôle camion";
        return view('checkpoint.index',compact('breadcrumb'));
    })->name('checkpoint.index');
});

