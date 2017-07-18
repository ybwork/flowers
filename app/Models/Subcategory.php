<?php

namespace App\Models;

use DB;

class Subcategory
{
    public function get_subcategories()
    {
        $sql = "SELECT sub.id, sub.name, GROUP_CONCAT(DISTINCT cat.id, cat.name  SEPARATOR ', ') AS categories FROM subcategories sub INNER JOIN categories_subcategories cat_sub ON sub.id = cat_sub.subcategory_id INNER JOIN categories cat ON cat_sub.category_id = cat.id GROUP BY sub.id";

        $subcat_cats = DB::select(DB::raw($sql));

        return $subcat_cats;
    }

    public function create($name, $categories)
    {
    	$subcategory_id = DB::table('subcategories')->insertGetId([
    		'name' => $name
    	]);

        $result = 0;
    	foreach ($categories as $category) {
    		DB::table('categories_subcategories')->insert([
    			'category_id' => $category,
    			'subcategory_id' => $subcategory_id
    		]);
            $result;
    	}

    	return $result;
    }

    public function show($id)
    {
        $sql = "SELECT sub.id, sub.name, GROUP_CONCAT(DISTINCT cat.id, cat.name  SEPARATOR ', ') AS categories FROM subcategories sub INNER JOIN categories_subcategories cat_sub ON sub.id = cat_sub.subcategory_id INNER JOIN categories cat ON cat_sub.category_id = cat.id WHERE sub.id = $id GROUP BY sub.id";

        $subcategory = DB::select(DB::raw($sql));

        return $subcategory;
    }

    public function update($id, $name, $categories)
    {
        DB::table('subcategories')->where('id', $id)->update([
            'name' => $name,
        ]);

        DB::table('categories_subcategories')->where('subcategory_id', $id)->delete();

        $result = 0;
        foreach ($categories as $category) {
            DB::table('categories_subcategories')->insert([
                'category_id' => $category,
                'subcategory_id' => $id,
            ]);
            $result++;
        }

        return $result;
    }

    public function delete($id)
    {
        DB::table('subcategories')->where('id', $id)->delete();

        DB::table('products_categories_subcategories')
                        ->where('subcategory_id', $id)
                        ->update(array(
                            'subcategory_id' => NULL,
                        ));

        DB::table('categories_subcategories')->where('subcategory_id', $id)->delete();
    }
}
