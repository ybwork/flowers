<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Site\CartController;
use App\Http\Controllers\Site\ProductController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product, CartController $cart)
    {
        // dd(Auth::user()->role != 1);
        $products = $product->get_products();
        // dd($products);
        $cart = $cart->show_products();
        return view('site.home', [
            'products' => $products,
            'cart' => $cart
        ]);
    }
}
