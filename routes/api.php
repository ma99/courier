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

Route::get('/divisions', 'Api\SearchCitiesController@divisionList');
Route::get('/districts', 'Api\SearchCitiesController@districtList');
Route::get('/booking', 'Api\SearchBookingController@bookingList');
Route::get('/searchByBookingRef', 'Api\SearchBookingController@searchBookingByRef');
Route::get('/searchByNameOrPhone', 'Api\SearchBookingController@searchBookingByNameOrPhone');
Route::get('/items', 'Api\SearchItemController@itemsForPagination');
Route::get('/all-items', 'Api\SearchItemController@itemList');