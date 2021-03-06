<?php

namespace App\Models;

use DB;
use Illuminate\Pagination\Paginator;

class Subcategory
{
    /**
     * Gets all subcategories from db
     *
     * @return array data or http error 500
     */
    public function get_subcategories()
    {
        $sql = "SELECT sub.id, sub.name, GROUP_CONCAT(DISTINCT cat.id, cat.name  SEPARATOR ', ') AS categories FROM subcategories sub LEFT JOIN categories_subcategories cat_sub ON sub.id = cat_sub.subcategory_id LEFT JOIN categories cat ON cat_sub.category_id = cat.id GROUP BY sub.id ORDER BY sub.id DESC";

        $subcat_cats = DB::select(DB::raw($sql));

        return $subcat_cats;
    }

    /**
     * Creates subcategory in db
     *
     * @param $name - category name
     * @param $categories - parent categories 
     * @return true or page with error 500
     */
    public function create(string $name, array $categories)
    {
        DB::beginTransaction();

        try {
            $subcategory_id = DB::table('subcategories')->insertGetId([
                'name' => $name
            ]);

            $categories_subcategories = [];
            // For multiple insert
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

    /**
     * Gets selected subcategory from db 
     *
     * @param $id - subcategory id
     * @return data subcategory or http error 500
     */
    public function show(int $id)
    {
        $sql = "SELECT sub.id, sub.name, GROUP_CONCAT(DISTINCT cat.id, cat.name  SEPARATOR ', ') AS categories FROM subcategories sub LEFT JOIN categories_subcategories cat_sub ON sub.id = cat_sub.subcategory_id LEFT JOIN categories cat ON cat_sub.category_id = cat.id WHERE sub.id = $id GROUP BY sub.id";

        return DB::select(DB::raw($sql));
    }

    /**
     * Updates subcategory in db
     *
     * @param $id - subcategory id
     * @param $name - subcategory name
     * @param $categories - parent categories
     * @return true or page with error 500
     */
    public function update(int $id, string $name, array $categories)
    {
        DB::beginTransaction();

        try {
            DB::table('subcategories')->where('id', $id)->update([
                'name' => $name,
            ]);

            DB::table('categories_subcategories')->where('subcategory_id', $id)->delete();

            $categories_subcategories = [];
            // For multiple insert
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

    /**
     * Delete subcategory from db
     *
     * @param $id - subcategory id
     * @return true or page with error 500
     */
    public function delete(int $id)
    {
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
