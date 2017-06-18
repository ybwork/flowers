<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class ProductController extends Controller
{
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
        $response['message'] = 'Товар добавлен в корзину';
        
        return json_encode($response);
    }

    public function delete_from_cart(Request $request)
    {
        $product_id = $request->input('product_id');

        $session = Session::all();

        $arr = [];

        // To be able to remove the element
        foreach ($session['products'] as $key => $value) {
            $arr[$key] = $value;
        }

        $products = array_flip($arr);

        unset($products[$product_id]);

        try {
            Session::pull('products');

            foreach ($products as $key => $value) {
                Session::push('products', $key);
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
