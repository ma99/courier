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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/changePassword','UsersController@showChangePasswordForm')->name('password.change.form');
Route::post('/changePassword','UsersController@changePassword')->name('password.change');

Route::get('/user', 'UsersController@index');

//Route::get('/userRegister', 'UserController@showRegisterForm');
Route::post('/register-user', 'Admin\AdminUserController@addNewUser')->name('register.user');

Route::get('/main', function () {
    return view('main.main');
});

Route::get('/{vue?}', function () {
    return view('main.main');           // view('pages.admin')
})->where('vue', '[\/\w\.-]*');


Route::post('/booking', 'BookingController@store');
Route::post('/shipment', 'ShipmentController@store');
Route::post('/search', 'ShipmentController@search');