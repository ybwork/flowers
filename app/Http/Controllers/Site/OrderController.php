<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Session, Auth;

class OrderController extends Controller
{
    /**
     * Collect data for create order
     * 
     * @param Request $request - object with data from form
     * @param Order $order - model for work with order
     * @return json response about success or fail
     */
    public function create(Request $request, Order $order)
    {
        $user_id = Auth::user()->id;
        $products_ids = Session::get('products');

        $order_id = $order->create($user_id, $products_ids, $request['count']);

        $order_info = $order->get_info($order_id);

    	// Когда появиться домен тут будет отправка инфы на почту

    	if ($order_id && $order_info) {
            Session::forget('products');

    		$response['status'] = 'success';

    		echo json_encode($response);
    	} else {
    		$response['status'] = 'fail';
            
    		echo json_encode($response);
    	}
    }
}
