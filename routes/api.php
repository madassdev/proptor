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
    Route::post('register', 'RegisterController@register');
    Route::post('login', 'LoginController@login');
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
    Route::group(['prefix'=>'tutors'], function(){
        Route::post('{tutor}/approve', 'UserController@approveTutor');
    });

    
    Route::resource('categories', 'CategoryController');
    Route::resource('courses', 'CourseController');
});


