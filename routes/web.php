<?php

use Illuminate\Support\Facades\Route;



Route::get('/', ['as' => '/', 'uses' => 'App\Http\Controllers\LoginController@index']);

Route::get('/serviceworker.js', function () {
    return response()->file(public_path('serviceworker.js'));
});


Route::get('/submit-shopping-list', function () {
    return view('submit-shopping-list');
})->name('submit-shopping-list');

Route::post('/submitLogin', ['as' => 'submitLogin', 'uses' => 'App\Http\Controllers\LoginController@submitLogin']);
Route::group(['middleware' => ['admin']], function () {
    Route::get('/logout', ['as' => 'logout', 'uses' => 'App\Http\Controllers\LoginController@logout']);
    Route::get('/change-password', ['as' => 'change-password', 'uses' => 'App\Http\Controllers\LoginController@change_password_get']);
    Route::post('/change-password', ['as' => 'change-password', 'uses' => 'App\Http\Controllers\LoginController@change_password_post']);
    Route::get('/dashboard', ['as' => '/dashboard', 'uses' => 'App\Http\Controllers\DashboardController@index']);

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

    Route::get('/users_search', ['as' => 'users_search', 'uses' => 'App\Http\Controllers\SuperAdmin\UserController@searchUser']);
    Route::get('/search-category', ['as' => 'search-category', 'uses' => 'App\Http\Controllers\SuperAdmin\CategoryController@searchCategory']);
    Route::get('/search-locations', ['as' => 'search-locations', 'uses' => 'App\Http\Controllers\SuperAdmin\LocationController@searchLocation']);
    Route::get('/search-units', ['as' => 'search-units', 'uses' => 'App\Http\Controllers\SuperAdmin\UnitController@searchUnit']);
    Route::get('/search-master-kitchen-inventory', ['as' => 'search-master-kitchen-inventory', 'uses' => 'App\Http\Controllers\SuperAdmin\MasterKitchenInventoryController@searchMasterKitchenInventory']);

    Route::get('/list-items', ['as' => 'list-items', 'uses' => 'App\Http\Controllers\SuperAdmin\MasterKitchenInventoryController@index']);
    Route::post('/add-items', ['as' => 'add-items', 'uses' => 'App\Http\Controllers\SuperAdmin\MasterKitchenInventoryController@addItem']);
    Route::get('/edit-items', ['as' => 'edit-items', 'uses' => 'App\Http\Controllers\SuperAdmin\MasterKitchenInventoryController@editItem']);
    Route::post('/update-items', ['as' => 'update-items', 'uses' => 'App\Http\Controllers\SuperAdmin\MasterKitchenInventoryController@updateItem']);
    Route::post('/delete-items', ['as' => 'delete-items', 'uses' => 'App\Http\Controllers\SuperAdmin\MasterKitchenInventoryController@deleteItem']);

    Route::get('/get-shopping-list-super-admin', ['as' => 'get-shopping-list-super-admin', 'uses' => 'App\Http\Controllers\SuperAdmin\ShoppingListController@getShopppingListSuperAdmin']);
    Route::post('/update-kitchen-inventory-by-super-admin', ['as' => 'update-kitchen-inventory-by-super-admin', 'uses' => 'App\Http\Controllers\SuperAdmin\ShoppingListController@updateKitchenInventoryBySuperAdmin']);
    Route::get('/get-submited-shopping-list-super-admin', ['as' => 'get-submited-shopping-list-super-admin', 'uses' => 'App\Http\Controllers\SuperAdmin\ShoppingListController@getSubmitedShopppingListSuperAdmin']);
    Route::get('/search-sopping-list', ['as' => 'search-sopping-list', 'uses' => 'App\Http\Controllers\SuperAdmin\ShoppingListController@searchShoppingList']);
    

    Route::get('/get-location-wise-inventory-sa', ['as' => 'get-location-wise-inventory-sa', 'uses' => 'App\Http\Controllers\SuperAdmin\ShoppingListController@getLocationWiseInventorySA']);
    Route::post('/add-kitchen-inventory-by-sa', ['as' => 'add-kitchen-inventory-by-sa', 'uses' => 'App\Http\Controllers\SuperAdmin\ShoppingListController@addKitchenInventoryBySuperAdmin']);
    
    Route::get('/get-activity-log', ['as' => 'get-activity-log', 'uses' => 'App\Http\Controllers\SuperAdmin\ActivityLogController@getActivityLog']);
    Route::get('/search-activity', ['as' => 'search-activity', 'uses' => 'App\Http\Controllers\SuperAdmin\ActivityLogController@searchActivityLog']);

    Route::get('/list-approve-users', ['as' => 'list-approve-users', 'uses' => 'App\Http\Controllers\SuperAdmin\UserController@getApproveUsers']);
    Route::post('/update-approve-users', ['as' => 'update-approve-users', 'uses' => 'App\Http\Controllers\SuperAdmin\UserController@updateOne']);
    Route::post('/update-approve-users-all-data', ['as' => 'update-approve-users-all-data', 'uses' => 'App\Http\Controllers\SuperAdmin\UserController@updateApproveUserAllData']);
    Route::post('/delete-approve-users', ['as' => 'delete-approve-users', 'uses' => 'App\Http\Controllers\SuperAdmin\UserController@deleteApproveUser']);


    Route::post('/copy-master-inventory', ['as' => 'copy-master-inventory', 'uses' => 'App\Http\Controllers\SuperAdmin\MasterKitchenInventoryController@copyMasterInventory']);
    Route::get('/get-inventory-history-view', ['as' => 'get-inventory-history-view', 'uses' => 'App\Http\Controllers\SuperAdmin\ShoppingListController@getInventory']);
    Route::post('/search-master-kitchen-inventory-history', ['as' => 'search-master-kitchen-inventory-history', 'uses' => 'App\Http\Controllers\SuperAdmin\ShoppingListController@getInventorySubmitHistory']);

    Route::get('/search-update-kitchen-inventory', ['as' => 'search-update-kitchen-inventory', 'uses' => 'App\Http\Controllers\Admin\ShoppingListController@SearchUpdateKitchenInventory']);
    Route::get('/search-update-kitchen-inventory-manager', ['as' => 'search-update-kitchen-inventory-manager', 'uses' => 'App\Http\Controllers\Manager\ShoppingListController@SearchUpdateKitchenInventoryManager']);
    Route::get('/search-update-kitchen-inventory-super-admin', ['as' => 'search-update-kitchen-inventory-super-admin', 'uses' => 'App\Http\Controllers\SuperAdmin\ShoppingListController@SearchUpdateKitchenInventorySuperAdmin']);

    Route::get('/search-shopping-list-manager', ['as' => 'search-shopping-list-manager', 'uses' => 'App\Http\Controllers\Manager\ShoppingListController@searchShoppingListManager']);

    
});


Route::group(['middleware' => ['admin']], function () {
    Route::get('/logout', ['as' => 'logout', 'uses' => 'App\Http\Controllers\LoginController@logout']);
    Route::get('/dashboard', ['as' => '/dashboard', 'uses' => 'App\Http\Controllers\DashboardController@index']);
    Route::post('/update-shopping-list-manager', ['as' => 'update-shopping-list-manager', 'uses' => 'App\Http\Controllers\Manager\ShoppingListController@updateShoppingListManager']);

    
    Route::post('/location_selected', ['as' => 'location_selected', 'uses' => 'App\Http\Controllers\Manager\ShoppingListController@getLocationSelected']);
    Route::get('/get-location-wise-inventory', ['as' => 'get-location-wise-inventory', 'uses' => 'App\Http\Controllers\Manager\ShoppingListController@getLocationWiseInventory']);
    Route::post('/update-kitchen-inventory-by-manager', ['as' => 'update-kitchen-inventory-by-manager', 'uses' => 'App\Http\Controllers\Manager\ShoppingListController@updateKitchenInventoryByManager']);
    Route::post('/add-kitchen-inventory-by-manager', ['as' => 'add-kitchen-inventory-by-manager', 'uses' => 'App\Http\Controllers\Manager\ShoppingListController@addKitchenInventoryByManager']);


    Route::get('/get-shopping-list-admin', ['as' => 'get-shopping-list-admin', 'uses' => 'App\Http\Controllers\Admin\ShoppingListController@getShopppingListAdmin']);
    Route::post('/location-selected-admin', ['as' => 'location-selected-admin', 'uses' => 'App\Http\Controllers\Admin\ShoppingListController@getLocationSelectedAdmin']);
    Route::post('/add-kitchen-inventory-by-admin', ['as' => 'add-kitchen-inventory-by-admin', 'uses' => 'App\Http\Controllers\Admin\ShoppingListController@addKitchenInventoryByAdmin']);
    Route::post('/update-kitchen-inventory-by-admin', ['as' => 'update-kitchen-inventory-by-admin', 'uses' => 'App\Http\Controllers\Admin\ShoppingListController@updateKitchenInventoryByAdmin']);
    Route::get('/get-submited-shopping-list-admin', ['as' => 'get-submited-shopping-list-admin', 'uses' => 'App\Http\Controllers\Admin\ShoppingListController@getSubmitedShopppingListAdmin']);

    Route::get('/list-admin-users', ['as' => 'list-admin-users', 'uses' => 'App\Http\Controllers\Admin\UserController@index']);
    Route::post('/add-admin-users', ['as' => 'add-admin-users', 'uses' => 'App\Http\Controllers\Admin\UserController@addUser']);
    Route::get('/edit-admin-users', ['as' => 'edit-admin-users', 'uses' => 'App\Http\Controllers\Admin\UserController@editUser']);
    Route::post('/update-admin-users', ['as' => 'update-admin-users', 'uses' => 'App\Http\Controllers\Admin\UserController@updateUser']);
    Route::post('/delete-admin-users', ['as' => 'delete-admin-users', 'uses' => 'App\Http\Controllers\Admin\UserController@deleteUser']);
    Route::get('/users_search_admin', ['as' => 'users_search_admin', 'uses' => 'App\Http\Controllers\Admin\UserController@searchUser']);

    Route::get('/get-inventory-history-manager', ['as' => 'get-inventory-history-manager', 'uses' => 'App\Http\Controllers\Admin\ShoppingListController@getInventoryHistoryManager']);
    Route::get('/get-inventory-pdf', ['as' => 'get-inventory-pdf', 'uses' => 'App\Http\Controllers\Manager\ShoppingListController@downloadInventoryHistory']);

    Route::get('/get-submited-shopping-list-manager', ['as' => 'get-submited-shopping-list-manager', 'uses' => 'App\Http\Controllers\Manager\ShoppingListController@getSubmitedShopppingListManager']);

});
