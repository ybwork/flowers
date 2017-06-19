<?php

Route::group(['prefix' => 'admin', 'middleware' => 'admin_auth'], function() {
	// Category
	Route::get('/', [
		'as' => 'admin_home',
		'uses' => 'Admin\AdminController@index',
	]);

	Route::get('categories', [
		'as' => 'admin_categories',
		'uses' => 'Admin\CategoryController@index'
	]);

	Route::post('category/store', [
		'as' => 'category_store',
		'uses' => 'Admin\CategoryController@store'
	]);

	Route::get('category/{id}/{name}/edit', [
		'as' => 'category_edit',
		'uses' => 'Admin\CategoryController@edit'
	]);

	Route::put('category/update', [
		'as' => 'category_update',
		'uses' => 'Admin\CategoryController@update'
	]);

	Route::delete('category/delete', [
		'as' => 'category_destroy',
		'uses' => 'Admin\CategoryController@destroy'
	]);

	// Subcategory
	Route::get('subcategories', [
		'as' => 'admin_subcategories',
		'uses' => 'Admin\SubcategoryController@index'
	]);

	Route::post('subcategory/store', [
		'as' => 'subcategory_store',
		'uses' => 'Admin\SubcategoryController@store'
	]);
});

Route::get('/', [
	'as' => 'home',
	'uses' => 'Site\HomeController@index'
]);

Route::get('/cart', [
	'as' => 'cart',
	'uses' => 'Site\CartController@index'
]);

Route::group(['prefix' => 'product'], function() {
	Route::post('/add-to-cart', [
		'as' => 'product_add_to_cart',
		'uses' => 'Site\ProductController@add_to_cart'
	]);

	Route::delete('/delete-from-cart', [
		'as' => 'product_delete_from_cart',
		'uses' => 'Site\ProductController@delete_from_cart'
	]);
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
