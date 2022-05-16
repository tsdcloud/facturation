<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
   
    Route::get('home', function () {
        if (Auth::check()) {
          //  dd("ok");
            if(Auth::user()->role == "user"){
                return view('invoice');
            }else{
                return view('home');
            }
        }
    });
    Route::get('billing', function () {
        return view('invoice');
    });
    Route::get('pdf', function () {
        return view('viewPdf');
    });
    Route::get('ok',[InvoiceController::class, 'pdf']);
});

