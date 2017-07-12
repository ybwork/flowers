<?php

namespace App\Models;

use DB;

class Product
{
    public function get_products()
    {
    	// $sql = '';
    	// $products = DB::select(DB::raw($sql));
    	$products = DB::table('products')
						->where('status', 1)
						->orderBy('id', 'DESC')
						->get();
    	return $products;
    }

    public function create($data)
    {
        $product_id = DB::table('products')->insertGetId([
            'name' => $data['name'],
            'description' => $data['description'],
            'image' => $data['image'],
            'price' => $data['price'],
            'status' => $data['status']
        ]);
        // dd($product);

        foreach ($data['category'] as $category_id) {
            $subcategory_id = '';
            foreach ($data['subcategory'] as $subcategory) {
                $subcategory_id =  $subcategory;
            }  
            DB::table('products_categories_subcategories')->insert([
                'product_id' => $product_id,
                'category_id' => $category_id,
                'subcategory_id' => $subcategory_id,
            ]);
        }
    }
}
