<?php

namespace App\Models;
use DB;

class Order
{
    public function create(int $user_id, array $products_ids, array $count)
    {

        $user_product_count = [];

        $i = 0;
        foreach ($products_ids as $key => $product_id) {
            $user_product_count[$i]['user_id'] = $user_id;
            $user_product_count[$i]['product_id'] = $product_id;
            $user_product_count[$i]['count'] = $count[$key];

            $i++;
        }

        return DB::table('users_orders')->insert($user_product_count);
    }

    public function get_info(int $user_id, array $products_ids)
    {
    	$orders_info = [];

    	foreach ($products_ids as $product_id) {
    		$sql = "SELECT u.id, u.name, u.phone, u_o.count, GROUP_CONCAT(DISTINCT p.name, p.price SEPARATOR ', ') AS products FROM users_orders u_o JOIN users u ON u.id = $user_id JOIN products p ON p.id = $product_id GROUP BY u_o.count";

    		$orders = DB::select(DB::raw($sql));

    		foreach ($orders as $order) {
    			array_push($orders_info, $order);
    		}
    	}
        
    	return $orders_info;
    }
}
