<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
});

// Route::get('/approve-users', function () {
//     return view('approve-users');
// });

Route::get('/approve-users', function () {
    return view('approve-users');
})->name('approve-users');

Route::get('/submit-shopping-list', function () {
    return view('submit-shopping-list');
})->name('submit-shopping-list');

Route::get('/activity', function () {
    return view('activity');
})->name('activity');

Route::get('/users', function () {
    return view('users');
})->name('users');

Route::get('/location', function () {
    return view('location');
})->name('location');

Route::get('/category', function () {
    return view('category');
})->name('category');

Route::get('/manage-units', function () {
    return view('manage-units');
})->name('manage-units');

Route::get('/kitchen-inventory', function () {
    return view('kitchen-inventory');
})->name('kitchen-inventory');

Route::get('/master-inventory', function () {
    return view('master-inventory');
})->name('master-inventory');

// Route::get('/submit-shopping-list', function () {
//     return view('submit-shopping-list');
// })->name('submit-shopping-list');

// Route::get('/', ['as' => '/', 'uses' => 'App\Http\Controllers\LoginController@index']);
Route::post('/submitLogin', ['as' => 'submitLogin', 'uses' => 'App\Http\Controllers\LoginController@submitLogin']);
Route::group(['middleware' => ['admin']], function () {
    // Route::post('/logout', ['as' => 'logout', 'uses' => 'App\Http\Controllers\Admin\LoginRegister\LoginController@logout']);
    // Route::get('/dashboard', ['as' => '/dashboard', 'uses' => 'App\Http\Controllers\Admin\Dashboard\DashboardController@index']);
    // Route::get('/list-users', ['as' => 'list-users', 'uses' => 'App\Http\Controllers\Admin\LoginRegister\RegisterController@index']);
    // Route::get('/add-users', ['as' => 'add-users', 'uses' => 'App\Http\Controllers\Admin\LoginRegister\RegisterController@addUsers']);
    // Route::post('/add-users', ['as' => 'add-users', 'uses' => 'App\Http\Controllers\Admin\LoginRegister\RegisterController@register']);
    // Route::get('/edit-users/{edit_id}', ['as' => 'edit-users', 'uses' => 'App\Http\Controllers\Admin\LoginRegister\RegisterController@editUsers']);
    // Route::post('/update-users', ['as' => 'update-users', 'uses' => 'App\Http\Controllers\Admin\LoginRegister\RegisterController@update']);
    // Route::post('/delete-users', ['as' => 'delete-users', 'uses' => 'App\Http\Controllers\Admin\LoginRegister\RegisterController@delete']);
    // Route::post('/show-users', ['as' => 'show-users', 'uses' => 'App\Http\Controllers\Admin\LoginRegister\RegisterController@show']);

    Route::get('/list-locations', ['as' => 'list-locations', 'uses' => 'App\Http\Controllers\SuperAdmin\LocationController@index']);
    Route::post('/add-locations', ['as' => 'add-locations', 'uses' => 'App\Http\Controllers\SuperAdmin\LocationController@AddLocation']);
    Route::post('/update-locations', ['as' => 'update-locations', 'uses' => 'App\Http\Controllers\SuperAdmin\LocationController@updateLocation']);
});
