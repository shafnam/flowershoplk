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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Basic Pages
Route::get('/', 'HomeController@index')->name('index');
Route::get('/contact', 'HomeController@contact')->name('contact');
Route::post('/contact', 'HomeController@postContactUs')->name('contactUs');

// Products
Route::get('/products', 'ProductsController@index')->name('products');
//Route::get('/products/category/{category}', 'ProductsController@index')->name('productsCatView');
Route::get('/products/{item_id}','ProductsController@show')->name('product.view.get');

// Cart
Route::post('/add-to-cart/{item_id}','CartsController@addItem')->name('addTocart');
Route::post('/update-cart/{item_id}', 'CartsController@updateItem')->name('updateCart');
Route::delete('/remove-item/{pid}','CartsController@removeItem')->name('removeFromCart');
Route::get('/cart','CartsController@showCart')->name('shoppingCart');

// Order
Route::get('/order','OrdersController@orderItems')->name('orderItems.get');
Route::get('/guest-order','OrdersController@orderItemsGuest')->name('orderItemsGuest.get');
Route::post('/process-payment','OrdersController@saveOrder')->name('saveOrder.post');
//Route::get('/process-payment','OrdersController@showOrder')->name('showOrder.get');
Route::get('/process-payment/{id}','OrdersController@showOrder')->name('showOrder.get');

// Payhere
Route::get('/return','OrdersController@payhereReturn')->name('returnPayment');
Route::any('/notify','OrdersController@payhereNotify')->name('notifyPayment');
//Route::any('/notify','OrdersController@payhereNotify');
Route::get('/cancel','OrdersController@payhereCancel')->name('cancelPayment');

// User
//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/logout','Auth\LoginController@userLogout')->name('user.logout');
Route::get('/user/order-history','UsersController@orderHistory')->name('user.orderHistory');
Route::get('/user/order-view/{id}','UsersController@orderView')->name('user.orderView');

// Footer Pages
Route::get('/about-us', 'HomeController@aboutUs')->name('aboutUs');
Route::get('/new-products', 'HomeController@newProducts')->name('newProducts');
Route::get('/top-sellers', 'HomeController@topSellers')->name('topSellers');
Route::get('/special-offers', 'HomeController@specialOffers')->name('specialOffers');
Route::get('/suppliers', 'HomeController@suppliers')->name('suppliers');


//admin route for our multi-auth system

Route::prefix('admin')->group(function () {
    
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    // Dashboard Chart
    Route::get('/sales-data', 'AdminController@orderChart')->name('admin.dashboard.chart');
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    //Route::get('/logout','Auth\AdminLoginController@logout')->name('admin.logout');
    Route::post('/logout','Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/register','Auth\AdminRegisterController@register')->name('admin.register');

    //admin password reset routes
    Route::post('/password/email','Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset','Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset','Auth\AdminResetPasswordController@reset');
    Route::get('/password/reset/{token}','Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');

    /************ 
        The following routes are only accessible by the editor user 
    *******************/
    Route::group(['middleware' => 'App\Http\Middleware\EditorMiddleware'], function() {
        
        /**
         *  Order routes
        **/
        Route::get('/orders/list','Admin\OrdersController@ordersList')->name('admin.orders.list');
        Route::get('/orders/view/{id}','Admin\OrdersController@orderView')->name('admin.order.view.get');
        Route::get('/orders/edit/{id}','Admin\OrdersController@orderEdit')->name('admin.order.edit.get');
        Route::post('/orders/edit/{id}','Admin\OrdersController@orderUpdate')->name('admin.order.edit.post');
        Route::post('/orders/bulk-edit','Admin\OrdersController@orderBulkUpdate')->name('admin.order.bulk-edit.post'); 

        /************ 
            The following routes are only accessible by the admin user 
        *******************/
        Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function() {
            
            /**
             *  Customer routes
            **/
            Route::get('/customers/list','Admin\UsersController@usersList')->name('admin.users.list');
            Route::get('/customers/view/{id}','Admin\UsersController@userView')->name('admin.user.view.get');

            /**
             *  Shops routes
            **/
            Route::get('/shops/list','Admin\ShopsController@shopsList')->name('admin.shops.list');
            Route::get('/shops/list/{id}','Admin\ShopsController@shopsList')->name('admin.shops.list.id');
            Route::get('/shops/add','Admin\ShopsController@shopAdd')->name('admin.shop.add.get');
            Route::post('/shops/add','Admin\ShopsController@shopSave')->name('admin.shop.add.post');
            Route::get('/shops/view/{id}','Admin\ShopsController@shopView')->name('admin.shop.view.get');
            Route::get('/shops/edit/{id}','Admin\ShopsController@shopEdit')->name('admin.shop.edit.get');
            Route::post('/shops/edit/{id}','Admin\ShopsController@shopUpdate')->name('admin.shop.edit.post');
            Route::delete('/shops/deactivate/{id}','Admin\ShopsController@shopDeactivate')->name('admin.shop.deactivate');
            Route::delete('/shops/activate/{id}','Admin\ShopsController@shopActivate')->name('admin.shop.activate');
            Route::post('/shops/bulk-edit','Admin\ShopsController@shopBulkUpdate')->name('admin.shop.bulk-edit.post');        

            /**
             *  Import Excel
            **/
            //Route::get('/import-export-view', 'Admin\ExcelController@importExportView')->name('import.export.view');
            Route::post('/import-file', 'Admin\ExcelController@importFile')->name('admin.import.file');
            Route::get('/export-file/{type}', 'Admin\ExcelController@exportFile')->name('admin.export.file');

            /**
             *  Commissions routes
            **/
            Route::get('/commissions/list','Admin\CommissionsController@commissionsList')->name('admin.commissions.list');
            Route::get('/commissions/view/{id}','Admin\CommissionsController@commissionView')->name('admin.commissions.view.get');

            //Route::match(['get', 'post'], '/products/list', 'Admin\ProductsController@productsList');

            /**
             *  Order routes
            **/
            // Route::get('/orders/list','Admin\OrdersController@ordersList')->name('admin.orders.list');
            // Route::get('/orders/view/{id}','Admin\OrdersController@orderView')->name('admin.order.view.get');
            // Route::get('/orders/edit/{id}','Admin\OrdersController@orderEdit')->name('admin.order.edit.get');
            // Route::post('/orders/edit/{id}','Admin\OrdersController@orderUpdate')->name('admin.order.edit.post');
            // Route::post('/orders/bulk-edit','Admin\OrdersController@orderBulkUpdate')->name('admin.order.bulk-edit.post');

        });
        
    });

    /************ 
        The following routes are only accessible by the prodocut editor user 
    *******************/
    Route::group(['middleware' => 'App\Http\Middleware\ProductEditorMiddleware'], function() {
        
        /**
         *  Product routes
        **/
        Route::get('/products/list','Admin\ProductsController@productsList')->name('admin.products.list');
        Route::get('/products/list/{id}','Admin\ProductsController@productsList')->name('admin.products.list.id');
        Route::get('/products/add','Admin\ProductsController@productAdd')->name('admin.product.add.get');
        Route::post('/products/add','Admin\ProductsController@productSave')->name('admin.product.add.post');
        Route::get('/products/view/{id}','Admin\ProductsController@productView')->name('admin.product.view.get');
        Route::get('/products/edit/{id}','Admin\ProductsController@productEdit')->name('admin.product.edit.get');
        Route::post('/products/edit/{id}','Admin\ProductsController@productUpdate')->name('admin.product.edit.post');
        Route::delete('/products/deactivate/{id}','Admin\ProductsController@productDeactivate')->name('admin.products.deactivate');
        Route::delete('/products/activate/{id}','Admin\ProductsController@productActivate')->name('admin.products.activate');

        /************ 
            The following routes are only accessible by the admin user 
        *******************/
        Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function() {
            
            /**
             *  Customer routes
            **/
            Route::get('/customers/list','Admin\UsersController@usersList')->name('admin.users.list');
            Route::get('/customers/view/{id}','Admin\UsersController@userView')->name('admin.user.view.get');

            /**
             *  Shops routes
            **/
            Route::get('/shops/list','Admin\ShopsController@shopsList')->name('admin.shops.list');
            Route::get('/shops/list/{id}','Admin\ShopsController@shopsList')->name('admin.shops.list.id');
            Route::get('/shops/add','Admin\ShopsController@shopAdd')->name('admin.shop.add.get');
            Route::post('/shops/add','Admin\ShopsController@shopSave')->name('admin.shop.add.post');
            Route::get('/shops/view/{id}','Admin\ShopsController@shopView')->name('admin.shop.view.get');
            Route::get('/shops/edit/{id}','Admin\ShopsController@shopEdit')->name('admin.shop.edit.get');
            Route::post('/shops/edit/{id}','Admin\ShopsController@shopUpdate')->name('admin.shop.edit.post');
            Route::delete('/shops/deactivate/{id}','Admin\ShopsController@shopDeactivate')->name('admin.shop.deactivate');
            Route::delete('/shops/activate/{id}','Admin\ShopsController@shopActivate')->name('admin.shop.activate');
            Route::post('/shops/bulk-edit','Admin\ShopsController@shopBulkUpdate')->name('admin.shop.bulk-edit.post');        

            /**
             *  Import Excel
            **/
            //Route::get('/import-export-view', 'Admin\ExcelController@importExportView')->name('import.export.view');
            Route::post('/import-file', 'Admin\ExcelController@importFile')->name('admin.import.file');
            Route::get('/export-file/{type}', 'Admin\ExcelController@exportFile')->name('admin.export.file');

            /**
             *  Commissions routes
            **/
            Route::get('/commissions/list','Admin\CommissionsController@commissionsList')->name('admin.commissions.list');
            Route::get('/commissions/view/{id}','Admin\CommissionsController@commissionView')->name('admin.commissions.view.get');

            //Route::match(['get', 'post'], '/products/list', 'Admin\ProductsController@productsList');
        });
        
    });

});