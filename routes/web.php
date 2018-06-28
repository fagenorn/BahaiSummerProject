<?php

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

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::any('/', function () {
    return redirect(session('locale') ?: Lang::getLocale());
});

Route::get('register/{sub}', function ($sub) {
    return redirect(session('locale') ?: Lang::getLocale() . $sub);
});

Route::get('groups/{id}/invoice', 'InvoiceController@create');
Route::get('groups/export', 'InvoiceController@download');
Route::get('groups/export/payments', 'InvoiceController@downloadPayments');
Route::get('groups/export/meals', 'InvoiceController@downloadMeals');
Route::get('groups/export/accommodation', 'InvoiceController@downloadAccommodation');
Route::get('groups/export/age_language', 'InvoiceController@downloadAgeLanguage');
Route::get('groups/export/free_paying', 'InvoiceController@downloadFreePaying');
Route::get('groups/export/days_distribution', 'InvoiceController@downloadDaysDistribution');

Route::prefix('{lang?}')->middleware('locale')->group(function () {
    Route::get('/', function () {
        return redirect(session('locale') . '/register/create');
    });
    Route::get('register/create', 'RegisterController@create');
    Route::get('register/success', function () {
        return view('success');
    });
});

Route::post('register', 'RegisterController@store');