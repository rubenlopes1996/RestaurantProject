<?php

use Illuminate\Http\Request;

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

//Menu
Route::get('menu', 'ItemControllerAPI@index');

//Authetication
Route::post('/register', 'API\AuthController@register');
Route::post('/login', 'API\AuthController@login');
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', 'API\AuthController@logout');
    Route::get('/get-user', 'API\AuthController@getUser');

    //Order
    Route::get('orders', 'OrderControllerAPI@index');
});

//Employees
Route::get('employees', 'UserControllerAPI@index');
Route::get('employee/{id}', 'UserControllerAPI@show');
Route::post('employee', 'UserControllerAPI@store');
Route::put('employee/{id}', 'UserControllerAPI@update');
Route::delete('employee/{id}', 'UserControllerAPI@destroy');

//Restaurant tables
Route::get('restaurant-tables', 'RestaurantTableAPI@index');

//Cashiers
Route::get('invoices', 'InvoicesControllerAPI@index');

