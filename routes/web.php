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

Auth::routes();
Route::get('/', function () {
    return redirect()->route('login');
});
Route::group(['middleware' => ['role','auth']], function () {

    Route::get('/dashboard', 'DashboardController@monthlyVisitor');

    Route::resource('buku', 'BookController');
    Route::resource('pengunjung', 'VisitorController');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('profile/{id}', 'VisitorController@showProfile')->name('profile.show');
    Route::get('profile/{id}/edit', 'VisitorController@editProfile')->name('profile.edit');
    Route::put('profile/{id}', 'VisitorController@updateProfile')->name('profile.update');

    Route::get('perhitungan','CalculationController@showCalc')->name('calc.show');


    // AJAX
    Route::get('dashboard/bukularis', 'DashboardController@bukuLaris')->name('dashboard.chart1');
    Route::get('dashboard/pengunjungBulanan', 'DashboardController@pengunjungBulanan')->name('dashboard.chart2');


});
Route::get('perhitungan/similarity','CalculationController@cosineSimilarity')->name('calc.sim');
Route::get('perhitungan/prediction','CalculationController@prediction')->name('calc.predict');

