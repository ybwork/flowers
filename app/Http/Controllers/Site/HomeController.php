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
     * Show home page with products
     *
     * @param Product $product - model for work with product
     * @param CartController $cart - controller for work with data cart
     * @return html view
     */
    public function index(Product $product, CartController $cart)
    {
        $products = $product->get_products();
        $cart = $cart->show_products();

        return view('site.home', [
            'products' => $products,
            'cart' => $cart
        ]);
    }
}
