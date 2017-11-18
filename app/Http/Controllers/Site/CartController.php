<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Controller;
use Session, DB;

class CartController extends Controller
{
	/**
     * Shows cart with products
     *
     * @return html view
     */
	public function index()
	{
		$cart = Session::get('products');

		$products = collect([]);

		$subtotal = 0;

		if ($cart) {
			// For more information about product by id
			$query = DB::table('products');
			foreach ($cart as $key => $product_id) {
				$query->orWhere('id', $product_id);
			}

			$arr = $query->get()->toArray();

			foreach ($arr as $value) {
				$products->push($value);
				$subtotal += $value->price;
			}
		}

		return view('site.cart', [
			'products' => $products,
			'cart' => $cart,
			'subtotal' => $subtotal,
		]);
	}

	/**
     * Shows products from cart
     *
     * @return array with products
     */
	public function show_products()
	{
		$cart = [];

		$session = Session::all();

		if (Session::has('products')) {
			$arr = [];

			// For work with condition buttons "Add to cart" and "Remove from cart"
			foreach ($session['products'] as $key => $value) {
				$arr[$key] = $value;
			}
			
			$cart = array_flip($arr);
		}

		return $cart;
	}
}
