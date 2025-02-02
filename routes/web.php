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


Route::get('/', ['as' => '/', 'uses' => 'App\Http\Controllers\LoginController@index']);

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

// Route::get('/users', function () {
//     return view('users');
// })->name('users');

// Route::get('/location', function () {
//     return view('location');
// })->name('location');

// Route::get('/category', function () {
//     return view('category');
// })->name('category');

// Route::get('/manage-units', function () {
//     return view('manage-units');
// })->name('manage-units');

Route::get('/kitchen-inventory', function () {
    return view('kitchen-inventory');
})->name('kitchen-inventory');

// Route::get('/master-inventory', function () {
//     return view('master-inventory');
// })->name('master-inventory');

// Route::get('/submit-shopping-list', function () {
//     return view('submit-shopping-list');
// })->name('submit-shopping-list');

// Route::get('/', ['as' => '/', 'uses' => 'App\Http\Controllers\LoginController@index']);
Route::post('/submitLogin', ['as' => 'submitLogin', 'uses' => 'App\Http\Controllers\LoginController@submitLogin']);
Route::group(['middleware' => ['admin']], function () {
    Route::get('/logout', ['as' => 'logout', 'uses' => 'App\Http\Controllers\LoginController@logout']);
    Route::get('/dashboard', ['as' => '/dashboard', 'uses' => 'App\Http\Controllers\DashboardController@index']);
    // Route::get('/list-users', ['as' => 'list-users', 'uses' => 'App\Http\Controllers\Admin\LoginRegister\RegisterController@index']);
    // Route::get('/add-users', ['as' => 'add-users', 'uses' => 'App\Http\Controllers\Admin\LoginRegister\RegisterController@addUsers']);
    // Route::post('/add-users', ['as' => 'add-users', 'uses' => 'App\Http\Controllers\Admin\LoginRegister\RegisterController@register']);
    // Route::get('/edit-users/{edit_id}', ['as' => 'edit-users', 'uses' => 'App\Http\Controllers\Admin\LoginRegister\RegisterController@editUsers']);
    // Route::post('/update-users', ['as' => 'update-users', 'uses' => 'App\Http\Controllers\Admin\LoginRegister\RegisterController@update']);
    // Route::post('/delete-users', ['as' => 'delete-users', 'uses' => 'App\Http\Controllers\Admin\LoginRegister\RegisterController@delete']);
    // Route::post('/show-users', ['as' => 'show-users', 'uses' => 'App\Http\Controllers\Admin\LoginRegister\RegisterController@show']);

    Route::get('/list-locations', ['as' => 'list-locations', 'uses' => 'App\Http\Controllers\SuperAdmin\LocationController@index']);
    Route::post('/add-locations', ['as' => 'add-locations', 'uses' => 'App\Http\Controllers\SuperAdmin\LocationController@AddLocation']);
    Route::get('/edit-locations', ['as' => 'edit-locations', 'uses' => 'App\Http\Controllers\SuperAdmin\LocationController@editLocation']);
    Route::post('/update-locations', ['as' => 'update-locations', 'uses' => 'App\Http\Controllers\SuperAdmin\LocationController@updateLocation']);
    Route::post('/delete-locations', ['as' => 'delete-locations', 'uses' => 'App\Http\Controllers\SuperAdmin\LocationController@deleteLocation']);

    Route::get('/list-category', ['as' => 'list-category', 'uses' => 'App\Http\Controllers\SuperAdmin\CategoryController@index']);
    Route::post('/add-category', ['as' => 'add-category', 'uses' => 'App\Http\Controllers\SuperAdmin\CategoryController@AddCategory']);
    Route::get('/edit-category', ['as' => 'edit-category', 'uses' => 'App\Http\Controllers\SuperAdmin\CategoryController@editCategory']);
    Route::post('/update-category', ['as' => 'update-category', 'uses' => 'App\Http\Controllers\SuperAdmin\CategoryController@updateCategory']);
    Route::post('/delete-category', ['as' => 'delete-category', 'uses' => 'App\Http\Controllers\SuperAdmin\CategoryController@deleteCategory']);

    Route::get('/list-units', ['as' => 'list-units', 'uses' => 'App\Http\Controllers\SuperAdmin\UnitController@index']);
    Route::post('/add-units', ['as' => 'add-units', 'uses' => 'App\Http\Controllers\SuperAdmin\UnitController@AddUnit']);
    Route::get('/edit-units', ['as' => 'edit-units', 'uses' => 'App\Http\Controllers\SuperAdmin\UnitController@editUnit']);
    Route::post('/update-units', ['as' => 'update-units', 'uses' => 'App\Http\Controllers\SuperAdmin\UnitController@updateUnit']);
    Route::post('/delete-units', ['as' => 'delete-units', 'uses' => 'App\Http\Controllers\SuperAdmin\UnitController@deleteUnit']);

    Route::get('/list-users', ['as' => 'list-users', 'uses' => 'App\Http\Controllers\SuperAdmin\UserController@index']);
    Route::post('/add-users', ['as' => 'add-users', 'uses' => 'App\Http\Controllers\SuperAdmin\UserController@addUser']);
    Route::get('/edit-users', ['as' => 'edit-users', 'uses' => 'App\Http\Controllers\SuperAdmin\UserController@editUser']);
    Route::post('/update-users', ['as' => 'update-users', 'uses' => 'App\Http\Controllers\SuperAdmin\UserController@updateUser']);
    Route::post('/delete-users', ['as' => 'delete-users', 'uses' => 'App\Http\Controllers\SuperAdmin\UserController@deleteUser']);

    Route::get('/list-items', ['as' => 'list-items', 'uses' => 'App\Http\Controllers\SuperAdmin\MasterKitchenInventoryController@index']);
    Route::post('/add-items', ['as' => 'add-items', 'uses' => 'App\Http\Controllers\SuperAdmin\MasterKitchenInventoryController@addItem']);
    Route::get('/edit-items', ['as' => 'edit-items', 'uses' => 'App\Http\Controllers\SuperAdmin\MasterKitchenInventoryController@editItem']);
    Route::post('/update-items', ['as' => 'update-items', 'uses' => 'App\Http\Controllers\SuperAdmin\MasterKitchenInventoryController@updateItem']);
    Route::post('/delete-items', ['as' => 'delete-items', 'uses' => 'App\Http\Controllers\SuperAdmin\MasterKitchenInventoryController@deleteItem']);

});


Route::group(['middleware' => ['admin']], function () {
    Route::get('/logout', ['as' => 'logout', 'uses' => 'App\Http\Controllers\LoginController@logout']);
    Route::get('/dashboard', ['as' => '/dashboard', 'uses' => 'App\Http\Controllers\DashboardController@index']);
    Route::get('/get-shopping-list-manager', ['as' => 'get-shopping-list-manager', 'uses' => 'App\Http\Controllers\Manager\ShoppingListController@getShopppingListManager']);
    Route::post('/update-shopping-list-manager', ['as' => 'update-shopping-list-manager', 'uses' => 'App\Http\Controllers\Manager\ShoppingListController@updateShoppingListManager']);

   
});
