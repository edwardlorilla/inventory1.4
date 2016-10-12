<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


use Illuminate\Http\Request;

Route::controller('auth', 'Auth\AuthController', ['getLogin' => 'auth.login']);
Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => 'web'], function() {
    Route::auth();
    Route::get('/home', 'HomeController@index')->name('admin.home');
    Route::resource('admin/users', 'AdminUsersController');
    Route::resource('admin/address', 'AdminAddressController', ['only' => ['index', 'store', 'update']]);
    Route::resource('admin/reservation','AdminReservationController');
    Route::get('admin/equipment', function() {
        return view('admin.equipment.index');
    });
    Route::resource('admin/nonconsumables','AdminConsumablesController', ['only' => ['create']]);;

    Route::resource('admin/equipment', 'AdminEquipmentController');
    Route::get('admin/users/{users/confirm}',['as'=>'admin.users.confirm', 'uses'=>'AdminUsersController@confirm']);
    Route::delete('admin/roles', 'AdminRolesController@destroy');
    Route::resource('admin/roles','AdminRolesController');
    Route::delete('admin/categories', 'AdminCategoriesController@destroy');
    Route::resource('admin/categories','AdminCategoriesController');
    Route::resource('admin/keyholder','AdminKeyholderController');
    Route::resource('admin/location','AdminLocationController');
    Route::resource('admin/borrow','AdminBorrowController');
    Route::resource('admin/propertyinventory','AdminPropertyinventoryController');
    Route::post('admin/borrows/{id?}', 'AdminBorrowController@store')->name('admin.borrows.store');
    Route::post('admin/equipment/{id?}', 'AdminEquipmentController@store')->name('admin.equipment.store');

    Route::delete('admin/equipment/', 'AdminEquipmentController@destroy')->name('admin.equipment.delete');

    Route::get('home', ['as' => 'admin.dashboard.index', 'uses' => 'AdminDashboardController@index']);

   
});
