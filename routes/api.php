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

//US1
Route::get('menu', 'ItemControllerAPI@index');
//US3
Route::post('/login', 'API\AuthController@login')->name('login');

//Authetication
Route::middleware('auth:api')->group(function () {
    Route::get('/get-user', 'API\AuthController@getUser');

    //US3
    Route::post('/logout', 'API\AuthController@logout');

    //US4
    Route::patch('employee/confirm/{email}', 'API\AuthController@confirmActivation');

    //US5
    Route::put('employee-profile/{id}', 'UserControllerAPI@updateProfile');
    Route::post('employee-photo/{id}', 'UserControllerAPI@uploadPhoto');

    //US6
    Route::put('startShift/{id}', 'UserControllerAPI@startShift');
    Route::put('endShift/{id}', 'UserControllerAPI@endShift');

    //US9
    Route::middleware('typeCook')->get('orders/{id}', 'OrderControllerAPI@index');

    //US11
    Route::middleware('typeCook')->patch('orders/inPreparation/{id}', 'OrderControllerAPI@inPreparation');
    Route::middleware('typeCook')->patch('orders/prepared/{id}', 'OrderControllerAPI@prepared');

    //US12
    Route::middleware('typeWaiter')->post('waiter/{id}/meal', 'MealsControllerAPI@store');

    //US13
    Route::middleware('typeWaiter')->post('addorders  ', 'OrderControllerAPI@store');

    //US14
    Route::middleware('typeWaiter')->get('waiter/list-orders/pending/confirmed', 'OrderControllerAPI@listOrderPendingConfirmed');

    //US15
    Route::middleware('typeWaiter')->delete('waiter/{id}/delete/order', 'OrderControllerAPI@destroy');

    //US17
    Route::middleware('typeWaiter')->get('meals/{id}', 'MealsControllerAPI@showMealsById');
    Route::middleware('typeWaiter')->get('waiter/{id}/orders/prepared', 'MealsControllerAPI@showMealsWithPreparedOrders');
    Route::middleware('typeWaiter')->patch('waiter/order/{id}/delivered', 'OrderControllerAPI@swapOrderToDelivered');

    //US19
    Route::middleware('typeWaiter')->get('waiter/{id}/meals/summary', 'MealsControllerAPI@showSummaryMeals');

    //US20 and 21
    Route::middleware('typeWaiter')->patch('waiter/{id}/meals/terminated', 'MealsControllerAPI@terminatedMeals');
    Route::middleware('typeWaiter')->put('waiter/{id}/meal/terminated/invoices', 'InvoicesControllerAPI@store');
    Route::middleware('typeWaiter')->patch('waiter/order/{id}/confirmed', 'OrderControllerAPI@swapOrderToConfirmed');
    Route::middleware('typeWaiter')->get('waiter/order/{id}/confirmed', 'OrderControllerAPI@swapOrderToConfirmed');

    //US22
    Route::middleware('typeCashier')->get('invoices', 'InvoicesControllerAPI@index');

    //US25 and 26
    Route::middleware('typeCashier')->put('invoices/{id}', 'InvoicesControllerAPI@update');

    //US27
    Route::middleware('typeCashier')->get('paidInvoices/download/{id}', 'InvoicesControllerAPI@downloadPDF');

    //US28
    Route::middleware('typeManager')->get('restaurant-tables', 'RestaurantTableAPI@index');
    Route::middleware('typeManager')->post('restaurant-tables', 'RestaurantTableAPI@create');
    Route::middleware('typeManager')->delete('restaurant-tables/{id}', 'RestaurantTableAPI@destroy');
    Route::middleware('typeManager')->get('restaurant-table/{id}', 'RestaurantTableAPI@show');
    Route::middleware('typeManager')->put('restaurant-table/{id}', 'RestaurantTableAPI@update');
    Route::middleware('typeManager')->delete('menu/{id}', 'ItemControllerAPI@destroy');
    Route::middleware('typeManager')->put('menu/{id}', 'ItemControllerAPI@update');
    Route::middleware('typeManager')->post('menu-photo/{id}', 'ItemControllerAPI@uploadPhoto');
    Route::middleware('typeManager')->post('menu', 'ItemControllerAPI@create');

    //US29
    Route::middleware('typeManager')->get('employees', 'UserControllerAPI@index');
    Route::middleware('typeManager')->post('/register', 'API\AuthController@register');
    Route::middleware('typeManager')->get('employee/{id}', 'UserControllerAPI@show');
    Route::middleware('typeManager')->post('employee', 'UserControllerAPI@store');
    Route::middleware('typeManager')->put('employee/{id}', 'UserControllerAPI@update');

    //US30
    Route::middleware('typeManager')->delete('employee/{id}', 'UserControllerAPI@destroy');
    Route::middleware('typeManager')->patch('employee/unblock/{id}', 'UserControllerAPI@unblock');
    Route::middleware('typeManager')->patch('employee/block/{id}', 'UserControllerAPI@block');

    //US32
    Route::middleware('typeManager')->put('meal/{id}/notPaid', 'MealsControllerAPI@notPaid');
    Route::middleware('typeManager')->put('invoice/{id}/notPaid', 'InvoicesControllerAPI@notPaid');

    //US35
    Route::middleware('typeManager')->get('list-meals', 'MealsControllerAPI@listmealsManager');
    Route::middleware('typeManager')->get('list/meals/summary', 'MealsControllerAPI@listmealsManagerSummary');

    //US36
    Route::middleware('typeManager')->get('list/meals/{data}', 'MealsControllerAPI@listMeals');

    //US37
    Route::middleware('typeManager')->get('list/meals/pending', 'InvoicesControllerAPI@listInvoicesPending');
    Route::middleware('typeManager')->get('list/invoices/{data}', 'InvoicesControllerAPI@listInvoicesPaidOrNotPaid');
    Route::middleware('typeManager')->get('list/invoices/date/{begindate}/{enddate}', 'InvoicesControllerAPI@listInvoicesDate');

    //US38
    Route::middleware('typeCashierOrManager')->get('invoices/paid', 'InvoicesControllerAPI@indexPaid');

    //US39 and 40
    Route::middleware('typeManager')->get('statistics/meals', 'StatisticsControllerAPI@getTotalMeals');
    Route::middleware('typeManager')->get('statistics/orders', 'StatisticsControllerAPI@getTotalOrders');
    Route::middleware('typeManager')->get('statistics/timeOrders', 'StatisticsControllerAPI@getAverageMinutesOrdersPerMonth');
    Route::middleware('typeManager')->get('statistics/timeMeals', 'StatisticsControllerAPI@getAverageMinutesMealPerMonth');
    Route::middleware('typeManager')->get('list/statistics', 'UserControllerAPI@showUsersWaiterCook');
    Route::middleware('typeManager')->get('list/statistics/{type}', 'UserControllerAPI@showUserByType');
    Route::middleware('typeManager')->get('list/statistics/waiter/{id}', 'UserControllerAPI@getInvoicesByWaiter');
    Route::middleware('typeManager')->get('statistics/waiter/{id}/date', 'StatisticsControllerAPI@statisticsByEmployeeAndDate');

    //Cashiers
    Route::get('invoices/{id}', 'InvoicesControllerAPI@show');
    //Waiters
    Route::get('meals', 'MealsControllerAPI@index');
});













