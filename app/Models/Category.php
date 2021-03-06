<?php

namespace App\Models;
use DB;

class Category
{
    /**
     * Gets all categories from db
     *
     * @return array data or http error 500
     */
	public function get_categories()
	{
        $sql = "SELECT c.id, c.name, GROUP_CONCAT(DISTINCT s.id, s.name SEPARATOR ', ') AS subcategories FROM categories c LEFT JOIN categories_subcategories c_s ON c.id = c_s.category_id LEFT JOIN subcategories s ON c_s.subcategory_id = s.id GROUP BY c.id ORDER BY c.id DESC";

        return DB::select(DB::raw($sql));
	}

    /**
     * Creates category in db
     *
     * @param $name - category name
     * @return true or page with error 500
     */
    public function create(string $name)
    {
    	$result = DB::table('categories')->insert([
			'name' => $name,
    	]);

    	return $result;
    }

    /**
     * Updates category in db
     *
     * @param $id - category id
     * @param $name - category name
     * @return true or page with error 500
     */
    public function update(int $id, string $name)
    {
    	return DB::table('categories')->where('id', $id)->update(['name' => $name]);
    }

    /**
     * Delete category with related data from db
     *
     * @param $id - category id
     * @return true or page with error 500
     */
    public function delete(int $id)
    {  
        DB::beginTransaction();

        try {            
            DB::table('categories')
                        ->where('id', $id)
                        ->delete();

            DB::table('categories_subcategories')
                        ->where('category_id', $id)
                        ->delete();

            DB::table('products_categories_subcategories')
                        ->where('category_id', $id)
                        ->delete();
        } catch (Exception $e) {
            DB::rollBack();
        }

        DB::commit();
    }
}
