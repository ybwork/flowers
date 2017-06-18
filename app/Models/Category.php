<?php

namespace App\Models;
use DB;

class Category
{
	public function getCategories()
	{
		return DB::table('categories')->select('id', 'name')->orderBy('id', 'DESC')->get();
	}

    public function save($name)
    {
    	$result = DB::table('categories')->insert([
			'name' => $name
    	]);

    	return $result;
    }

    public function update($id, $name)
    {
    	return DB::table('categories')->where('id', $id)->update(['name' => $name]);
    }

    public function delete($id)
    {
    	return DB::table('categories')->where('id', $id)->delete();
    }
}
