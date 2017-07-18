<?php

namespace App\Models;
use DB;

class Category
{
	public function get_categories()
	{
        return DB::table('categories')->select('id', 'name')->orderBy('id', 'DESC')->get();
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
        DB::table('products_categories_subcategories')
                    ->where('category_id', $id)
                    ->delete();
    	return DB::table('categories')->where('id', $id)->delete();
    }
}
