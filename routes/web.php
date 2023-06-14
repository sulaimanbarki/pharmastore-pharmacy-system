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

Route::group(['namespace' => 'Frontend'], function(){
	Route::get('/','HomeController@index')->name('main_home');
});

Auth::routes(['register' => false]);

Route::get('/admin/login','Auth\LoginController@showLoginForm');
Route::post('/admin/login','Auth\LoginController@login')->name('admin.login');

Route::get('/login','Frontend\LoginController@showLoginForm')->name('customer.signin');
Route::post('/login','Frontend\LoginController@login')->name('customer.signin.submit');
Route::get('/my-account','Frontend\UserController@myaccount')->name('myaccount');
Route::post('/account-details','Frontend\UserController@update_account_details')->name('update_account_details');
Route::post('/address-details','Frontend\UserController@update_address')->name('update_address');

Route::get('/register','Frontend\LoginController@showRegistrationForm')->name('customer.signup');
Route::post('/register','Frontend\LoginController@registerProcess')->name('customer.register');
Route::get('/cart','Frontend\HomeController@cart')->name('cart');
Route::post('/storecart','Frontend\HomeController@store_cart_data')->name('storecart');
Route::get('checkout','Frontend\HomeController@checkout')->name('checkout');
Route::post('orderprocess','Frontend\HomeController@orderprocess')->name('orderprocess');
Route::get('/order/success/{id}','Frontend\HomeController@order_success')->name('order_success');

Route::get('/order/failed','Frontend\HomeController@order_failed')->name('order_failed');

Route::get('wishlist/add/{id}','Frontend\UserController@add_wishlist')->name('add_wishlist');
Route::get('wishlist/remove/{id}','Frontend\UserController@remove_wishlist')->name('remove_wishlist');
Route::get('wishlist','Frontend\UserController@wishlist')->name('wishlist');
Route::get('view/details/{id}','Frontend\HomeController@product_details')->name('p_details');

Route::get('medicine-category/{id}','Frontend\HomeController@category_product')->name('category_product');
Route::get('group/{id}','Frontend\HomeController@group_product')->name('group_product');
Route::get('search/','Frontend\HomeController@search_product')->name('search');

Route::get('/about-us','Frontend\HomeController@about_us')->name('about');
Route::get('/contact','Frontend\ContactController@contact')->name('contact');
Route::post('/contact','Frontend\ContactController@contact_form_submit')->name('contact_submit');


Route::group(['middleware' => 'AuthMiddleware'], function(){
	Route::get('dashboard', 'adminHomeController@index');
	Route::get('/logout','adminHomeController@logout');

	Route::prefix('category')->group(function(){
		Route::get('/add', 'CategoryController@index');
		Route::post('/add', 'CategoryController@save');
		Route::post('/update', 'CategoryController@update');
		Route::get('/list', 'CategoryController@manage');
		Route::get('/edit/{id}', 'CategoryController@edit');
		Route::get('/delete/{id}', 'CategoryController@delete');
		Route::get('/publishStatus/{status}/{id}', 'CategoryController@publishStatus');
	});

	Route::prefix('groups')->group(function(){
		Route::get('/add', 'MedicineGroupController@index');
		Route::post('/add', 'MedicineGroupController@save');
		Route::post('/update', 'MedicineGroupController@update');
		Route::get('/list', 'MedicineGroupController@manage');
		Route::get('/edit/{id}', 'MedicineGroupController@edit');
		Route::get('/delete/{id}', 'MedicineGroupController@delete');
		Route::get('/publishStatus/{status}/{id}', 'MedicineGroupController@publishStatus');
	});

	Route::prefix('genericnames')->group(function(){
		Route::get('/add', 'GenericNamesController@index');
		Route::post('/add', 'GenericNamesController@save');
		Route::post('/update', 'GenericNamesController@update');
		Route::get('/list', 'GenericNamesController@manage');
		Route::get('/edit/{id}', 'GenericNamesController@edit');
		Route::get('/delete/{id}', 'GenericNamesController@delete');
		Route::get('/publishStatus/{status}/{id}', 'GenericNamesController@publishStatus');
	});

	Route::prefix('supplier')->group(function(){
		Route::get('/add', 'SupplierController@index');
		Route::post('/add', 'SupplierController@save');
		Route::post('/update', 'SupplierController@update');
		Route::get('/list', 'SupplierController@manage');
		Route::get('/edit/{id}', 'SupplierController@edit');
		Route::get('/delete/{id}', 'SupplierController@delete');
		Route::get('/publishStatus/{status}/{id}', 'SupplierController@publishStatus');
		
		Route::get('/invoiceadd/{id}', 'SupplierInvoiceController@invoiceadd');
		Route::get('/invoicelist', 'SupplierInvoiceController@invoicelist');
		Route::post('/invoiceCreate', 'SupplierInvoiceController@invoiceCreate');
		Route::get('/supplier', 'SupplierInvoiceController@index');
		Route::post('/invoice', 'SupplierInvoiceController@invoice');
		Route::get('/printInvoice/{invoice}/{id}', 'SupplierInvoiceController@print');
		Route::get('/details/{invoice}/{id}', 'SupplierInvoiceController@details');
		Route::get('/deleteinvoice/{id}', 'SupplierInvoiceController@delete');
	});


	Route::prefix('product')->group(function(){
		Route::post('/get_groups','ProductController@get_groups_by_categoryid')->name('ajax_groups');
		Route::get('/add', 'ProductController@index');
		Route::post('/add', 'ProductController@save');
		Route::post('/update', 'ProductController@update');
		Route::get('/list', 'ProductController@manage');
		Route::get('/edit/{id}', 'ProductController@edit');
        Route::get('/restock/{id}', 'ProductController@restock');
        Route::post('/updateStock', 'ProductController@updateStock');
		Route::get('/delete/{id}', 'ProductController@delete');
		Route::get('/details/{id}', 'ProductController@details');
		Route::get('/publishStatus/{status}/{id}', 'ProductController@publishStatus');
		Route::get('/oneMonthToexpire', 'ProductController@oneMonthToexpire');
        Route::get('/expired', 'ProductController@expired');
        Route::get('/stock-out', 'ProductController@stockOut');
        
	});


	Route::prefix('settings')->group(function(){
		Route::get('/', 'SettingsController@index');
		Route::post('/update', 'SettingsController@update');
	});

	Route::prefix('useroles')->group(function(){
		Route::get('/', 'UsersRoleController@index');
		Route::post('/add', 'UsersRoleController@save');
		Route::post('/update', 'UsersRoleController@update');
		Route::get('/list', 'UsersRoleController@manage');
		Route::get('/edit/{id}', 'UsersRoleController@edit');
		Route::get('/delete/{id}', 'UsersRoleController@delete');
	});

	Route::prefix('paymentmethods')->group(function(){
		Route::get('/', 'PaymentMethodController@index');
		Route::post('/add', 'PaymentMethodController@save');
		Route::post('/update', 'PaymentMethodController@update');
		Route::get('/list', 'PaymentMethodController@manage');
		Route::get('/edit/{id}', 'PaymentMethodController@edit');
		Route::get('/delete/{id}', 'PaymentMethodController@delete');
		Route::get('/publishStatus/{status}/{id}', 'PaymentMethodController@publishStatus');
	});

	Route::prefix('users')->group(function(){
		Route::get('/add', 'UserController@index');
		Route::post('/add', 'UserController@save');
		Route::post('/update', 'UserController@update');
		Route::get('/list', 'UserController@manage');
		Route::get('/edit/{id}', 'UserController@edit');
		Route::get('/delete/{id}', 'UserController@delete');
		Route::get('/profile', 'UserController@profile');
		Route::get('/activeStatus/{status}/{id}', 'UserController@activeStatus');
		Route::get('/reset/', 'UserController@reset');
		Route::post('/resetpassword/', 'UserController@resetpassword');
		Route::get('/editProfile/', 'UserController@editProfile');
		Route::get('/details/{id}', 'UserController@details');
		Route::get('/getUser/{id}', 'UserController@getUser');
	});


	Route::prefix('order')->group(function(){
		Route::post('/customer/','PlaceOrderController@create_customer')->name('create_order_customer');
		Route::get('/', 'PlaceOrderController@index');
        Route::get('/new', 'PlaceOrderController@new');
        Route::post('/save', 'PlaceOrderController@saveOrder');
		Route::post('/', 'PlaceOrderController@search');
		Route::get('/addToCart/{id}', 'PlaceOrderController@addToCart');
		Route::post('/add', 'PlaceOrderController@save');
		//Route::get('/checkout/{array}', 'PlaceOrderController@checkout');
		Route::get('/checkout/', 'PlaceOrderController@checkout')->name('order_checkout');

		Route::post('/placeOrder', 'PlaceOrderController@placeOrder');
		Route::get('/discountCalculation', 'PlaceOrderController@discountCalculation');
		Route::get('/getDiscount', 'PlaceOrderController@getDiscount');
		Route::get('/confirm', 'PlaceOrderController@confirm');
		Route::get('/list', 'PlaceOrderController@list');
		Route::get('/updateOrderStatus/{id}/{status}', 'PlaceOrderController@updateOrderStatus');
		Route::get('/details/{id}', 'PlaceOrderController@details');

	});

});

Route::group(['middleware' => 'client'], function(){
	//echo "a";exit();
	Route::get('/home', 'HomeController@index')->name('logged_home');
});



Route::get('/home', 'HomeController@index')->name('home');
