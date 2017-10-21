<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Site\CartController;
use App\Models\Product;

class ProductController extends Controller
{
    public function show(CartController $cart, Product $product, $id)
    {
        $product = $product->show($id);
        $cart = $cart->show_products();
        
        return view('site.product',[
            'product' => $product,
            'cart' => $cart
        ]);
    }

    public function add_to_cart(Request $request)
    {
        $product_id = $request->input('product_id');
        
        try {
            Session::push('products', $product_id);
        } catch (Exception $e){
            $response = [];
            $response['status'] = 'fail';
            $response['count'] = count(Session::get('products'));
            $response['message'] = 'Что то пошло не так!';

            return json_encode($response);          
        }

        $response = [];
        $response['status'] = 'added';
        $response['count'] = count(Session::get('products'));
        $response['product_id'] = $product_id;
        $response['message'] = 'Товар добавлен в корзину';
        
        return json_encode($response);
    }

    public function delete_from_cart(Request $request)
    {
        $product_id = $request['product_id'];
        
        $session = Session::all();

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
            $response['message'] = 'Что то пошло не так!';

            return json_encode($response);          
        }
        
        $response = [];
        $response['status'] = 'deleted';
        $response['count'] = count(Session::get('products'));
        $response['message'] = 'Товар удалён из корзины';

        return json_encode($response);
    }
}
