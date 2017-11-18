<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Site\CartController;

class CategoryController extends Controller
{
	/**
     * Shows products by categories
     *
     * @param $id - id category
     * @param $subcat_id - id subcategory
     * @param Product $product - model for work with product
     * @param CartController $cart - controller for work with cart
     * @return html view
     */
    public function show_cats_subcats($id, $subcat_id=NULL, Product $product, CartController $cart)
    {
        $products = $product->show_by_cats_subcats($id, $subcat_id);
        $cart = $cart->show_products();
        
        return view('site.category', [
        	'products' => $products,
        	'cart' => $cart
        ]);
    }
}
