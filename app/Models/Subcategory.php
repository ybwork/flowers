<?php

namespace App\Models;

use DB;

class Subcategory
{
    public function getSubcategories()
    {
    	return DB::table('subcategories')->select('id', 'name')->get();
    }

    public function store($categories, $name)
    {
    	$subcategory = DB::table('subcategories')->insertGetId([
    		'name' => $name
    	]);

    	foreach ($categories as $category) {
    		DB::table('categories_subcategories')->insert([
    			'category_id' => $category,
    			'subcategory_id' => $subcategory
    		]);
    	}

    	return $subcategory;
    }
}
