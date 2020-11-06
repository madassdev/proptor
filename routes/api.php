<?php

use App\Http\Controllers\TutorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace'=>'Auth', 'prefix'=>'auth'], function(){
    Route::post('register', 'ApiRegisterController@register');
    Route::post('login', 'ApiLoginController@login');
    Route::post('logout', 'LoginController@logout');
    Route::post('forgot-password', 'PasswordResetController@forgotPassword');
    Route::post('reset-password', 'PasswordResetController@resetPassword');
});

Route::group(['middleware'=>'auth:api'], function(){
    
    // USER
    Route::group(['prefix'=>'users'], function(){
        Route::get('', 'UserController@index');
        Route::get('me', 'UserController@me');
        Route::get('permitted-users', 'UserController@getPermittedUsers');
        Route::get('{user}', 'UserController@show');
        Route::put('{user}', 'UserController@update');
        Route::delete('{user}', 'UserController@destroy');
    });

    // TUTOR
    Route::group(['prefix'=>'agents'], function(){
        Route::post('{agent}/approve', 'UserController@approveAgent');
    });

    
});

Route::group(['prefix'=>'app'], function(){
    Route::get('details', 'AppController@getDetails');
    Route::get('keys/payment', 'AppController@getPaymentKeys');
    Route::post('keys/payment', 'AppController@savePaymentKeys')->middleware('auth:api');
});


Route::resource('types', 'TypeController');
Route::resource('features', 'FeatureController');
Route::resource('plans', 'PlanController');

Route::resource('properties', 'PropertyController');
Route::post('properties/search', 'PropertyController@search');
Route::post('properties/{property}/view', 'PropertyController@view');
Route::post('properties/favorites', 'PropertyController@favorites')->middleware('auth:api');
Route::post('properties/{property}/favorite', 'PropertyController@favorite')->middleware('auth:api');
Route::post('properties/{property}/unfavorite', 'PropertyController@unfavorite')->middleware('auth:api');

Route::get('analytics', 'SaleController@analytics')->middleware('auth:api');

Route::post('sales', 'SaleController@addSale')->middleware('auth:api');
Route::get('sales', 'SaleController@index')->middleware('auth:api');
Route::post('sales/{sale}/pay', 'SaleController@payForSale')->middleware('auth:api');
Route::get('payments', 'PaymentController@payments');
Route::post('payments/{payment}/confirm', 'PaymentController@confirmPayment');


