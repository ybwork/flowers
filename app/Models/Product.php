<?php

namespace App\Models;

use DB;

class Product
{
    public function getAllProducts()
    {
    	$products = DB::table('products')
    							->where('status', 1)
								->orderBy('id', 'DESC')
								->get();
    	return $products;
    }
}
