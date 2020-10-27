<?php

use App\Models\Payment;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/mailrouting/admin/payments/{payment}', 'PaymentController@confirmPayment')->name('mailroutes.admin.payments.show');

Auth::routes();

Route::name('admin.')->prefix('admin')->namespace('Admin')->group(function(){
    Route::get('/', 'AdminController@index')->name('index')->middleware('auth');
    Route::resource('users', 'UserController')->middleware('auth');
    Route::get('/users/{user}/sales', 'UserController@salesCreate')->name('users.sales.create')->middleware('auth');
    Route::post('/users/{user}/sales', 'UserController@salesStore')->name('users.sales.store')->middleware('auth');

    Route::get('/notifications/{notification}', 'NotificationController@read')->name('notifications.read')->middleware('auth');
    Route::get('/notifications/read/all', 'NotificationController@readAll')->name('notifications.read-all')->middleware('auth');

    Route::get('/sales', 'SaleController@index')->name('sales.index')->middleware('auth');
    Route::get('/sales/{sale}', 'SaleController@show')->name('sales.show')->middleware('auth');
    Route::post('/sales/{sale}/autopay', 'SaleController@autopay')->name('sales.autopay')->middleware('auth');

    Route::get('/payments', 'PaymentController@index')->name('payments.index')->middleware('auth');
    Route::get('/payments/{payment}', 'PaymentController@show')->name('payments.show')->middleware('auth');
    Route::put('/payments/{payment}', 'PaymentController@update')->name('payments.update')->middleware('auth');

    Route::get('/properties/{property}/edit-image', 'PropertyController@editImage')->name('properties.edit-image')->middleware('auth');
    Route::resource('properties', 'PropertyController')->middleware('auth');
    
    Route::resource('plans', 'PlanController')->middleware('auth');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
