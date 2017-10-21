<?php

namespace App\Models;

use DB;
use Illuminate\Pagination\Paginator;

class Subcategory
{
    public function get_subcategories()
    {
        $sql = "SELECT sub.id, sub.name, GROUP_CONCAT(DISTINCT cat.id, cat.name  SEPARATOR ', ') AS categories FROM subcategories sub LEFT JOIN categories_subcategories cat_sub ON sub.id = cat_sub.subcategory_id LEFT JOIN categories cat ON cat_sub.category_id = cat.id GROUP BY sub.id";

        $subcat_cats = DB::select(DB::raw($sql));

        return $subcat_cats;
    }

    public function create(string $name, array $categories)
    {
        DB::beginTransaction();

        try {
            $subcategory_id = DB::table('subcategories')->insertGetId([
                'name' => $name
            ]);

            $categories_subcategories = [];

            $i = 0;
            foreach ($categories as $cat) {
                $categories_subcategories[$i]['category_id'] = (int) $cat;
                $categories_subcategories[$i]['subcategory_id'] = $subcategory_id;

                $i++;
            }

            DB::table('categories_subcategories')->insert($categories_subcategories);
        } catch (Exception $e) {
            DB::rollBack();
        }

        DB::commit();
    }

    public function show(int $id)
    {
        $sql = "SELECT sub.id, sub.name, GROUP_CONCAT(DISTINCT cat.id, cat.name  SEPARATOR ', ') AS categories FROM subcategories sub LEFT JOIN categories_subcategories cat_sub ON sub.id = cat_sub.subcategory_id LEFT JOIN categories cat ON cat_sub.category_id = cat.id WHERE sub.id = $id GROUP BY sub.id";

        return DB::select(DB::raw($sql));
    }

    public function update(int $id, string $name, array $categories)
    {
        DB::beginTransaction();

        try {
            DB::table('subcategories')->where('id', $id)->update([
                'name' => $name,
            ]);

            DB::table('categories_subcategories')->where('subcategory_id', $id)->delete();

            $categories_subcategories = [];

            $i = 0;
            foreach ($categories as $cat) {
                $categories_subcategories[$i]['category_id'] = (int) $cat;
                $categories_subcategories[$i]['subcategory_id'] = $id;

                $i++;
            }

            DB::table('categories_subcategories')->insert($categories_subcategories);
        } catch (Exception $e) {
            DB::rollBack();
        }

        DB::commit();
    }

    public function delete(int $id)
    {
        /*
            Use this construction because if not exists this subcategories in table products_categories_subcategories then query return 0 and construction DB::transaction(function(){}) not work. 
        */
        DB::beginTransaction();

        try {
            DB::table('subcategories')->where('id', $id)->delete();

            DB::table('categories_subcategories')->where('subcategory_id', $id)->delete();  

            DB::table('products_categories_subcategories')
                ->where('subcategory_id', $id)
                ->update(array(
                    'subcategory_id' => NULL,
                ));
        } catch (Exception $e) {
            DB::rollBack();
        }

        DB::commit();
    }
}
