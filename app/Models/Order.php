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
        DB::beginTransaction();

        try {
            $order_id = DB::table('orders')->insertGetId([
                'user_id' => $user_id
            ]);

            $user_product_count = [];

            // For multiple insert
            $i = 0;
            foreach ($products_ids as $key => $product_id) {
                $user_product_count[$i]['order_id'] = (int) $order_id;
                $user_product_count[$i]['product_id'] = (int) $product_id;
                $user_product_count[$i]['product_count'] = (int) $count[$key];

                $i++;
            }

            DB::table('products_orders')->insert($user_product_count);
        } catch (Exception $e) {
            DB::rollBack();
        }

        DB::commit();

        return $order_id;
    }

    /**
     * Gets info about user order
     *
     * @return array with order info
     */
    public function get_info(int $order_id)
    {

        $sql = "SELECT o.id, o.user_id, u.name, u.phone, GROUP_CONCAT(DISTINCT p.name, '-', p.price, '-', p_o.product_count SEPARATOR ', ') AS products FROM orders o LEFT JOIN users u ON o.user_id = u.id LEFT JOIN products_orders p_o ON p_o.order_id = o.id LEFT JOIN products p ON p.id = p_o.product_id WHERE o.id = $order_id";

        $orders = DB::select(DB::raw($sql));

        $orders_info = [];

        $i = 0;
        foreach ($orders as $key => $order) {
            $orders_info[$i]['user_name'] = $order->name;
            $orders_info[$i]['user_phone'] = $order->phone;
            $orders_info[$i]['products'] = $order->products;

            $i++;
        }
        
    	return $orders_info;
    }
}
