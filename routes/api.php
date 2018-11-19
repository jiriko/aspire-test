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

Route::post('/users', [
    'as' => 'users.store',
    'uses' => 'UserController@store'
]);

Route::post('/loans', [
    'as' => 'loans.store',
    'uses' => 'LoanController@store'
]);

Route::post('/repayments/{repayment}/pay', [
    'as' => 'repayments.pay',
    'uses' => 'RepaymentPaymentController'
]);
