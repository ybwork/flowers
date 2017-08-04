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
		'as' => 'category_create',
		'uses' => 'Admin\CategoryController@create'
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
		'as' => 'category_delete',
		'uses' => 'Admin\CategoryController@delete'
	]);

	// Subcategory
	Route::get('subcategories', [
		'as' => 'admin_subcategories',
		'uses' => 'Admin\SubcategoryController@index'
	]);

	Route::post('subcategory/create', [
		'as' => 'subcategory_create',
		'uses' => 'Admin\SubcategoryController@create'
	]);

	Route::get('subcategory/{id}/edit', [
		'as' => 'subcategory_edit',
		'uses' => 'Admin\SubcategoryController@edit'
	]);

	Route::put('subcategory/update', [
		'as' => 'subcategory_update',
		'uses' => 'Admin\SubcategoryController@update'
	]);

	Route::delete('subcategory/delete', [
		'as' => 'subcategory_delete',
		'uses' => 'Admin\SubcategoryController@delete'
	]);

	// Product
	Route::get('products', [
		'as' => 'admin_products',
		'uses' => 'Admin\ProductController@index'
	]);

	Route::post('product/create', [
		'as' => 'product_create',
		'uses' => 'Admin\ProductController@create'
	]);

	Route::get('product/{id}/edit', [
		'as' => 'product_edit',
		'uses' => 'Admin\ProductController@edit'
	]);

	Route::put('product/update', [
		'as' => 'product_update',
		'uses' => 'Admin\ProductController@update'
	]);

	Route::delete('product/delete', [
		'as' => 'product_delete',
		'uses' => 'Admin\ProductController@delete'
	]);

	Route::put('product/move_out_stock', [
		'as' => 'admin_product_move',
		'uses' => 'Admin\ProductController@move'
	]);

	Route::get('products/out_stock', [
		'as' => 'admin_products_out_stock',
		'uses' => 'Admin\ProductController@show_out_stock'
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
	Route::get('/{id}', [
		'as' => 'show_product',
		'uses' => 'Site\ProductController@show'
	]);

	Route::post('/add-to-cart', [
		'as' => 'product_add_to_cart',
		'uses' => 'Site\ProductController@add_to_cart'
	]);

	Route::delete('/delete-from-cart', [
		'as' => 'product_delete_from_cart',
		'uses' => 'Site\ProductController@delete_from_cart'
	]);
});

Route::get('/category/{id}/{subcat_id?}', [
	'as' => 'cats_subcats',
	'uses' => 'Site\CategoryController@show_cats_subcats'
]);

Route::post('/order/create', [
	'as' => 'order_create',
	'uses' => 'Site\OrderController@create'
]);


Auth::routes();
