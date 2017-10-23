<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Session, Auth;

class OrderController extends Controller
{
    /**
     * Creates order
     * 
     * @param Request $request - object with data from form
     * @param Order $order - model for work with order
     * @return json response about success or fail
     */
    public function create(Request $request, Order $order)
    {
        $user_id = Auth::user()->id;
        $products_ids = Session::get('products');

        // $order_id = $order->create($user_id, $products_ids, $request['count']);

        $order_info = $order->get_info(3);
        dd($order_info);

    	// Тут отправка инфы на почту


    	// Перед выводом сообщения пользователю проверка на все этапы заказа (создание, вывод инвы, отправка админу)
    	$response = [];

    	if ($order && $order_info) {
            Session::forget('products');
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
