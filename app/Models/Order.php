<?php

namespace App\Models;
use DB;

class Order
{
    public function create($user_id, $products_id)
    {
    	foreach ($products_id as $product_id) {
    		$order = DB::table('users_orders')->insert(array(
    			'user_id' => $user_id,
    			'product_id' => $product_id
    		));
    	}

    	return $order;
    }

    public function get_info($user_id, $products_id)
    {
    	$orders_info = [];

    	foreach ($products_id as $product_id) {
    		$sql = "SELECT u.id, u.name, u.phone, GROUP_CONCAT(DISTINCT p.name, p.price SEPARATOR ', ') AS products FROM users u JOIN products p ON p.id = $product_id WHERE u.id = $user_id GROUP BY u.id";

    		$orders = DB::select(DB::raw($sql));

    		foreach ($orders as $order) {
    			array_push($orders_info, $order);
    		}
    	}
    	// dd($orders_info);
    	return $orders_info;
    }
}