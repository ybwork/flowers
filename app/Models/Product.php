<?php

namespace App\Models;

use DB;

class Product
{
    public function get_products()
    {
    	$sql = "SELECT p.id, p.name, p.description, p.image, p.price, p.status, GROUP_CONCAT(DISTINCT c.name SEPARATOR ', ') AS categories, GROUP_CONCAT(DISTINCT s.name SEPARATOR ', ') AS subcategories FROM products p INNER JOIN products_categories_subcategories p_c_s ON p.id = p_c_s.product_id INNER JOIN categories c ON c.id = p_c_s.category_id LEFT JOIN subcategories s ON s.id = p_c_s.subcategory_id WHERE p.status = 1 GROUP BY p.id";

    	$products = DB::select(DB::raw($sql));
        // dd($products);
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

        foreach ($data['category'] as $category_id) {
            if (isset($data['subcategory'])) {            
                foreach ($data['subcategory'] as $subcategory) {
                    $subcategory_id =  $subcategory;
                }  
            } else {
                $subcategory_id = $data['subcategory'];
            }

            DB::table('products_categories_subcategories')->insert([
                'product_id' => $product_id,
                'category_id' => $category_id,
                'subcategory_id' => $subcategory_id,
            ]);
        }
    }

    public function show($id)
    {
        $sql = "SELECT p.id, p.name, p.description, p.image, p.price, p.status, GROUP_CONCAT(DISTINCT c.id, c.name SEPARATOR ',') AS categories, GROUP_CONCAT(DISTINCT s.id, s.name SEPARATOR ',') AS subcategories FROM products p INNER JOIN products_categories_subcategories p_c_s ON p.id = p_c_s.product_id INNER JOIN categories c ON c.id = p_c_s.category_id LEFT JOIN subcategories s ON s.id = p_c_s.subcategory_id WHERE p.id = $id GROUP BY p.id";

        return DB::select(DB::raw($sql));
    }

    public function update($data)
    {
        DB::table('products')->where('id', $data['id'])->update(array(
            'name' => $data['name'],
            'description' => $data['description'],
            'image' => $data['image'],
            'price' => $data['price'],
            'status' => $data['status']
        ));

        DB::table('products_categories_subcategories')->where('product_id', $data['id'])->delete();

        foreach ($data['category'] as $category_id) {
            if (isset($data['subcategory'])) {            
                foreach ($data['subcategory'] as $subcategory) {
                    $subcategory_id =  $subcategory;
                }  
            } else {
                $subcategory_id = $data['subcategory'];
            }

            DB::table('products_categories_subcategories')->insert([
                'product_id' => $data['id'],
                'category_id' => $category_id,
                'subcategory_id' => $subcategory_id,
            ]);
        }
    }

    public function delete($id)
    {
        DB::table('products')->where('id', $id)->delete();
        DB::table('products_categories_subcategories')->where('product_id', $id)->delete();
    }
}
