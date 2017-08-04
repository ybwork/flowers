<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Session, Auth;

class OrderController extends Controller
{
    public function create(Request $request, Order $order)
    {
    	
    	$user_id = Auth::user()->id;
    	$products_id = Session::get('products');

    	$order_result = $order->create($user_id, $products_id);
    	$order_info = $order->get_info($user_id, $products_id);

    	// dd($order, $order_info);

    	// Перед выводом сообщения пользователю проверка на все этапы заказа (создание, вывод инвы, отправка админу)
    	$response = [];

    	if ($order && $order_info) {
    		$response['status'] = 'success';
    		$response['message'] = 'Заказ оформлен';

    		echo json_encode($response);
    	} else {
    		$response['status'] = 'fail';
    		$response['message'] = 'Что то пошло не так, попробуйте позже';

    		echo json_encode($response);
    	}
    }
}
