<?php

namespace App\Models;
use DB;

class Order
{
    /**
     * Creates order
     *
     * @param $name - category name
     * @return true or false
    */
    public function create(int $user_id, array $products_ids, array $count)
    {
        $user_product_count = [];

        // For multiple insert
        $i = 0;
        foreach ($products_ids as $key => $product_id) {
            $user_product_count[$i]['user_id'] = $user_id;
            $user_product_count[$i]['product_id'] = $product_id;
            $user_product_count[$i]['count'] = $count[$key];

            $i++;
        }

        return DB::table('users_orders')->insert($user_product_count);
    }

    /**
     * Gets info about user order
     *
     * @return array with order info
    */
    public function get_info(int $user_id, array $products_ids, array $count)
    {

    	$orders_info = [];

        // Using query in foreach because data 
        $i = 0;
        foreach ($products_ids as $product_id) {
            $sql = "SELECT u.name, u.phone, p.name AS product_name, p.price AS product_price FROM users u JOIN products p ON p.id = $product_id WHERE u.id = $user_id";

            $orders = DB::select(DB::raw($sql));

            foreach ($orders as $key => $order) {
                $orders_info[$i]['user_name'] = $order->name;
                $orders_info[$i]['user_phone'] = $order->phone;
                $orders_info[$i]['product_name'] = $order->product_name;
                $orders_info[$i]['product_price'] = $order->product_price;
                $orders_info[$i]['quantity_product'] = $count[$i];

                $i++;
            }
        }
        
    	return $orders_info;
    }
}
