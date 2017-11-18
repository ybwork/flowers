<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Site\CartController;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Show category which need edit
     *
     * @param CartController $cart - controller for work with cart
     * @param Product $product - model for work with product
     * @param $id - id product
     * @return html view
     */
    public function show(CartController $cart, Product $product, $id)
    {
        $product = $product->show($id);
        $cart = $cart->show_products();
        
        return view('site.product',[
            'product' => $product,
            'cart' => $cart
        ]);
    }

    /**
     * Adds product to cart
     *
     * @param Request $request - object with data from form
     * @return json response with success or fail
     */
    public function add_to_cart(Request $request)
    {
        $product_id = $request->input('product_id');
        
        try {
            Session::push('products', $product_id);
        } catch (Exception $e){
            $response = [];
            $response['status'] = 'fail';
            $response['count'] = count(Session::get('products'));
            $response['message'] = 'Something went wrong!';

            return json_encode($response);          
        }

        $response = [];
        $response['status'] = 'added';
        $response['count'] = count(Session::get('products'));
        $response['product_id'] = $product_id;
        $response['message'] = 'Success';
        
        return json_encode($response);
    }

    /**
     * Deletes product from cart
     *
     * @param Request $request - object with data from form
     * @return json response with success or fail
     */
    public function delete_from_cart(Request $request)
    {
        $product_id = $request['product_id'];
        
        $session = Session::all();

        // For delete this product from session
        for ($i = count($session['products']) - 1; $i >= 0; $i--) {
            if ($session['products'][$i] == $product_id) {
                unset($session['products'][$i]);
            }   
        }

        $products = $session['products'];

        try {
            Session::pull('products');

            foreach ($products as $key => $value) {
                Session::push('products', $value);
            }
        } catch (Exception $e){
            $response = [];
            $response['status'] = 'fail';
            $response['count'] = count(Session::get('products'));
            $response['message'] = 'Something went wrong!';

            return json_encode($response);          
        }
        
        $response = [];
        $response['status'] = 'deleted';
        $response['count'] = count(Session::get('products'));
        $response['message'] = 'Success';

        return json_encode($response);
    }
}
