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

//Authetication
Route::post('/register', 'API\AuthController@register');
Route::post('/login', 'API\AuthController@login')->name('login');
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', 'API\AuthController@logout');
    Route::get('/get-user', 'API\AuthController@getUser');

    //Order
    Route::get('orders/{id}', 'OrderControllerAPI@index');
    Route::patch('orders/inPreparation/{id}','OrderControllerAPI@inPreparation');
    Route::patch('orders/prepared/{id}','OrderControllerAPI@prepared');

});

//Employees
Route::get('employees', 'UserControllerAPI@index');
Route::get('employee/{id}', 'UserControllerAPI@show');
Route::post('employee', 'UserControllerAPI@store');
Route::put('employee/{id}', 'UserControllerAPI@update');
Route::delete('employee/{id}', 'UserControllerAPI@destroy');
Route::patch('employee/unblock/{id}','UserControllerAPI@unblock');
Route::patch('employee/block/{id}','UserControllerAPI@block');

//Restaurant tables
Route::get('restaurant-tables', 'RestaurantTableAPI@index');
Route::post('restaurant-tables', 'RestaurantTableAPI@create');
Route::delete('restaurant-tables/{id}','RestaurantTableAPI@destroy');

//Cashiers
Route::get('invoices', 'InvoicesControllerAPI@index');
Route::get('invoices/paid', 'InvoicesControllerAPI@indexPaid');
Route::get('invoices/{id}', 'InvoicesControllerAPI@show');
Route::put('invoices/{id}', 'InvoicesControllerAPI@update');
Route::get('paidInvoices/{id}/download','InvoicesControllerAPI@downloadPDF');

//My profile
Route::put('employee-profile/{id}', 'UserControllerAPI@update');
Route::post('employee-photo/{id}', 'UserControllerAPI@uploadPhoto');
Route::put('employeePassword/{id}', 'UserControllerAPI@updatePassword');

//Restaurant menu
Route::get('menu', 'ItemControllerAPI@index');
Route::delete('menu/{id}','ItemControllerAPI@destroy');
Route::put('menu/{id}','ItemControllerAPI@update');
Route::post('menu-photo/{id}', 'ItemControllerAPI@uploadPhoto');
Route::post('menu', 'ItemControllerAPI@create');

//Start shift
Route::put('startShift/{id}','UserControllerAPI@startShift');
//End shift
Route::put('endShift/{id}','UserControllerAPI@endShift');

//Waiters
Route::get('meals', 'MealsControllerAPI@index');
Route::post('waiter/{id}/meal','MealsControllerAPI@store');

Route::get('meals/{id}','MealsControllerAPI@showMealsById');
Route::post('addorders  ','OrderControllerAPI@store');

Route::get('waiter/list-orders/pending/confirmed', 'OrderControllerAPI@listOrderPendingConfirmed');

Route::delete('waiter/{id}/delete/order', 'OrderControllerAPI@destroy');

Route::get('waiter/{id}/orders/prepared','MealsControllerAPI@showMealsWithPreparedOrders');
Route::patch('waiter/order/{id}/delivered','OrderControllerAPI@swapOrderToDelivered');

Route::get('waiter/{id}/meals/summary','MealsControllerAPI@showSummaryMeals');

Route::patch('waiter/{id}/meals/terminated','MealsControllerAPI@terminatedMeals');


Route::put('waiter/{id}/meal/terminated/invoices', 'InvoicesControllerAPI@store');



//US35
Route::get('list-meals','MealsControllerAPI@listmealsManager');
Route::get('list/meals/summary','MealsControllerAPI@listmealsManagerSummary');
//US37
Route::get('list/meals/pending', 'InvoicesControllerAPI@listInvoicesPending');

//US36
Route::get('list/meals/{data}','MealsControllerAPI@listMeals');

Route::get('list/invoices/{data}','InvoicesControllerAPI@listInvoicesPaidOrNotPaid');
Route::get('list/invoices/date/{begindate}/{enddate}','InvoicesControllerAPI@listInvoicesDate');


Route::get('list/statistics','UserControllerAPI@showUsersWaiterCook');
Route::get('list/statistics/{type}','UserControllerAPI@showUserByType');


//fkusahia
Route::patch('waiter/order/{id}/confirmed','OrderControllerAPI@swapOrderToConfirmed');


