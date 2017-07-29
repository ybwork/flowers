<?php

namespace App\Models;
use DB;

class Category
{
	public function get_categories()
	{
        $sql = "SELECT c.id, c.name, GROUP_CONCAT(DISTINCT s.id, s.name SEPARATOR ', ') AS subcategories FROM categories c LEFT JOIN categories_subcategories c_s ON c.id = c_s.category_id LEFT JOIN subcategories s ON c_s.subcategory_id = s.id GROUP BY c.id";

        return DB::select(DB::raw($sql));
	}

    public function create($name)
    {
    	$result = DB::table('categories')->insert([
			'name' => $name,
    	]);

    	return $result;
    }

    public function update($id, $name)
    {
    	return DB::table('categories')->where('id', $id)->update(['name' => $name]);
    }

    public function delete($id)
    {  
        // $category_exists_in_product = DB::table('products_categories_subcategories')
        //             ->where('category_id', $id)
        //             ->get();
                    
        // $category_is_parent = DB::table('categories_subcategories')
        //                                     ->where('category_id', $id)
        //                                     ->get();

        // if (count($category_exists_in_product) == 0 && count($category_is_parent) == 0) {
        //     return DB::table('categories')->where('id', $id)->delete();
        // } else {
        //     return false;
        // }

        DB::table('categories')
                    ->where('id', $id)
                    ->delete();

        DB::table('categories_subcategories')
                    ->where('category_id', $id)
                    ->delete();

        DB::table('products_categories_subcategories')
                    ->where('category_id', $id)
                    ->delete();
    }
}
