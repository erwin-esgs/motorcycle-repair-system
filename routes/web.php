<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
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

Route::get('/login', [CustomerController::class, 'login'])->name('login');;
Route::get('/loginInput', [CustomerController::class, 'loginInput']);
Route::post('/register', [CustomerController::class, 'register']);
Route::post('/verification', [CustomerController::class, 'verify']);

Route::get('/admin', [LoginController::class, 'login']);
Route::post('/verify', [LoginController::class, 'verify']);
Route::get('/forgotpassAdmin', [LoginController::class, 'forgotpass']);
Route::get('/newpassAdmin', [LoginController::class, 'newpass']);
Route::post('/verifynewpassAdmin', [LoginController::class, 'verifynewpass']);

Route::get('/forgotpass', [CustomerController::class, 'forgotpass']);
Route::get('/newpass', [CustomerController::class, 'newpass']);
Route::post('/verifynewpass', [CustomerController::class, 'verifynewpass']);

Route::get('/logout', [CustomerController::class, 'logout']);

Route::get('/register', [LoginController::class, 'register']);

Route::group(['middleware' => ['auth:customer']], function() {
	Route::get('/dashboard', [DashboardController::class, 'dashboard']);
	
	Route::get('/booking', [BookingController::class, 'show']);
	Route::post('/booking', [BookingController::class, 'add']);
	Route::get('/booking/{id}', [BookingController::class, 'detail']);
	Route::post('/bookingEdit/{id}', [BookingController::class, 'edit']);
	Route::get('/bookingDelete/{id}', [BookingController::class, 'remove']);
	
	Route::get('/transactionCustomer', [TransactionController::class, 'showCustomer']);
});

Route::group(['middleware' => ['auth:web']], function() {
	Route::get('/dashboardAdmin', [DashboardController::class, 'dashboardAdmin']);
	
	Route::get('/allBooking', [BookingController::class, 'all']);
	Route::post('/chStatus', [TransactionController::class, 'ch_status']);

	Route::post('/accept', [BookingController::class, 'accept']);
	Route::get('/reject/{id}', [BookingController::class, 'reject']);
	Route::post('/insertStock', [TransactionController::class, 'insertStock']);
	
	Route::get('/transaction', [TransactionController::class, 'show']);
	Route::post('/transaction', [TransactionController::class, 'add']);
	Route::get('/transaction/{id}', [TransactionController::class, 'detail']);
	Route::post('/transactionEdit/{id}', [TransactionController::class, 'edit']);
	Route::get('/transactionDelete/{id}', [TransactionController::class, 'remove']);

	Route::get('/customer', [CustomerController::class, 'show']);
	//Route::post('/customer', [CustomerController::class, 'add']);
	Route::get('/customer/{id}', [CustomerController::class, 'detail']);
	Route::post('/customerEdit/{id}', [CustomerController::class, 'edit']);
	Route::get('/customerDelete/{id}', [CustomerController::class, 'remove']);

	Route::get('/stock', [StockController::class, 'show']);
	Route::post('/stock', [StockController::class, 'add']);
	Route::get('/stock/{id}', [StockController::class, 'detail']);
	Route::post('/stockEdit/{id}', [StockController::class, 'edit']);
	Route::get('/stockDelete/{id}', [StockController::class, 'remove']);

	Route::get('/user', [UserController::class, 'show']);
	Route::post('/user', [UserController::class, 'add']);
	Route::get('/user/{id}', [UserController::class, 'detail']);
	Route::post('/userEdit/{id}', [UserController::class, 'edit']);
	Route::get('/userDelete/{id}', [UserController::class, 'remove']);

	Route::get('/', function(){return redirect('/booking'); });
});



/*
Route::middleware([ 'auth'])->group(function(){
  Route::get('/logout', [LoginController::class, 'login']);
});
*/

