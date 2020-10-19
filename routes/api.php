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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login','ApiVisitorController@login');
Route::post('register','ApiVisitorController@register');
Route::middleware('auth:api')->group(function(){
    Route::get('books', 'ApiBookController@getBook');
    Route::get('books/detail/{id}','ApiBookController@detailBook');
    Route::get('books/search', 'ApiBookController@searchBook');

    // Route::get('recommendation','ApiBookController@getRecommend');
    Route::get('recommendation','ApiRecommendController@getRecommend');

    Route::post('books/rate/', 'ApiBookController@saveRate');
    Route::get('books/{bookId}/allRate','ApiBookController@allRate');
    Route::post('user/update', 'ApiVisitorController@updateProfile');
    Route::post('user/update/password', 'ApiVisitorController@updatePassword');
    Route::get('books/mostRated','ApiBookController@mostRatedBook');
});


