<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ProductControlller;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('signup', 'App\Http\Controllers\AuthController@signup');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');

});

Route::apiResource('/employee', 'App\Http\Controllers\Api\EmployeeController');
Route::get('/employee-edit/{id}', 'App\Http\Controllers\Api\EmployeeController@show');
Route::apiResource('/supplier', 'App\Http\Controllers\Api\SupplierController');
Route::apiResource('/category', 'App\Http\Controllers\Api\CategoryController');
Route::apiResource('/product', 'App\Http\Controllers\Api\ProductControlller');
Route::apiResource('/expense', 'App\Http\Controllers\Api\ExpenseController');
Route::apiResource('/customer', 'App\Http\Controllers\Api\CustomerController');

Route::Post('/salary/paid/{id}', 'App\Http\Controllers\Api\SalaryController@Paid');
Route::Get('/salary', 'App\Http\Controllers\Api\SalaryController@AllSalary');
Route::Get('/salary/view/{id}', 'App\Http\Controllers\Api\SalaryController@ViewSalary');
Route::Get('/edit/salary/{id}', 'App\Http\Controllers\Api\SalaryController@EditSalary');
Route::Post('/salary/update/{id}', 'App\Http\Controllers\Api\SalaryController@SalaryUpdate');

Route::Post('/stock/update/{id}', 'App\Http\Controllers\Api\ProductControlller@StockUpdate');

Route::Get('/getting/product/{id}', 'App\Http\Controllers\Api\PosController@GetProduct');
// Add to cart Route
Route::Get('/addToCart/{id}', 'App\Http\Controllers\Api\CartController@AddToCart');
Route::Get('/cart/product', 'App\Http\Controllers\Api\CartController@CartProduct');
Route::Get('/remove/cart/{id}', 'App\Http\Controllers\Api\CartController@removeCart');

Route::Get('/increment/{id}', 'App\Http\Controllers\Api\CartController@increment');
Route::Get('/decrement/{id}', 'App\Http\Controllers\Api\CartController@decrement');

Route::Get('/vats', 'App\Http\Controllers\Api\CartController@Vats');

Route::Post('/orderdone', 'App\Http\Controllers\Api\PosController@OrderDone');
// Order Route
Route::Get('/orders', 'App\Http\Controllers\Api\OrderController@TodayOrder');
Route::Get('/order/details/{id}', 'App\Http\Controllers\Api\OrderController@OrderDetails');
Route::Get('/order/orderdetails/{id}', 'App\Http\Controllers\Api\OrderController@OrderDetailsAll');

Route::Post('/search/order', 'App\Http\Controllers\Api\PosController@SearchOrderDate');

// Admin Dashboard Route

Route::Get('/today/sell', 'App\Http\Controllers\Api\PosController@TodaySell');
Route::Get('/today/income', 'App\Http\Controllers\Api\PosController@TodayIncome');
Route::Get('/today/due', 'App\Http\Controllers\Api\PosController@TodayDue');
Route::Get('/today/expense', 'App\Http\Controllers\Api\PosController@TodayExpense');
Route::Get('/today/stockout', 'App\Http\Controllers\Api\PosController@Stockout');

