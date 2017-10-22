<?php

namespace App\Models;

use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\UrlGenerator;

class Product
{
    /**
     * Gets all products
     *
     * @return object with all products
    */
    public function get_products()
    {
    	$sql = "SELECT p.id, p.name, p.description, p.image, p.price, p.stock_price, p.status, GROUP_CONCAT(DISTINCT c.name SEPARATOR ', ') AS categories, GROUP_CONCAT(DISTINCT s.name SEPARATOR ', ') AS subcategories FROM products p LEFT JOIN products_categories_subcategories p_c_s ON p.id = p_c_s.product_id LEFT JOIN categories c ON c.id = p_c_s.category_id LEFT JOIN subcategories s ON s.id = p_c_s.subcategory_id WHERE p.status = 1 GROUP BY p.id ORDER BY p.id DESC";

        $products = DB::select(DB::raw($sql));

        $current_page = 1;
        $per_page = 6;

        if (count($_REQUEST) > 0) {        
            $current_page = $_REQUEST['page'];
        }

        $offset = ($per_page * $current_page) - $per_page;

        $products = new LengthAwarePaginator(array_slice($products, $offset, $per_page, true), count($products), $per_page, $current_page);

    	return $products;
    }

    /**
     * Create array for record relationships prod-cat-subcat
     *
     * @param $product_id - unique product id
     * @param $categories - categories this product
     * @param $subcategories - subcategories this product
     * @return array relatioships
    */
    public function create_array_prods_cats_subcats(int $product_id, array $categories, $subcategories): array
    {
        $products_categories_subcategories = [];

        $i = 0;
        foreach ($categories as $category) {
            if (count($categories) == 1) {
                if (isset($subcategories)) {
                    foreach ($subcategories as $subcategory) {
                        $products_categories_subcategories[$i]['product_id'] = $product_id;
                        $products_categories_subcategories[$i]['category_id'] = $category;
                        $products_categories_subcategories[$i]['subcategory_id'] = $subcategory;

                        $i++;
                    }  
                } else {
                    $products_categories_subcategories[$i]['product_id'] = $product_id;
                    $products_categories_subcategories[$i]['category_id'] = $category;
                    $products_categories_subcategories[$i]['subcategory_id'] = $subcategories;
                }
            } else {
                if (isset($subcategories)) {
                    foreach ($subcategories as $subcategory) {
                        $products_categories_subcategories[$i]['product_id'] = $product_id;
                        $products_categories_subcategories[$i]['category_id'] = $category;
                        $products_categories_subcategories[$i]['subcategory_id'] = $subcategory;

                        $i++;
                    }  
                } else {
                    $products_categories_subcategories[$i]['product_id'] = $product_id;
                    $products_categories_subcategories[$i]['category_id'] = $category;
                    $products_categories_subcategories[$i]['subcategory_id'] = $subcategories;

                    $i++;
                }
            }
        }

        return $products_categories_subcategories; 
    }

    /**
     * Creates product
     *
     * @param $data - array data about product
     * @return true or false
    */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $product_id = DB::table('products')->insertGetId([
                'name' => $data['name'],
                'description' => $data['description'],
                'image' => $data['image'],
                'price' => $data['price'],
                'stock_price' => $data['stock_price'],
                'status' => $data['status']
            ]);

            $products_categories_subcategories = $this->create_array_prods_cats_subcats($product_id, $data['category'], $data['subcategory']);

            DB::table('products_categories_subcategories')->insert($products_categories_subcategories);
        } catch (Exception $e) {
            DB::rollBack();
        }

        DB::commit();
    }

    /**
     * Shows product
     *
     * @param $id - unique product id
     * @return data product
    */
    public function show(int $id)
    {
        $sql = "SELECT p.id, p.name, p.description, p.image, p.price, p.stock_price, p.status, GROUP_CONCAT(DISTINCT c.id, c.name SEPARATOR ',') AS categories, GROUP_CONCAT(DISTINCT s.id, s.name SEPARATOR ',') AS subcategories FROM products p LEFT JOIN products_categories_subcategories p_c_s ON p.id = p_c_s.product_id LEFT JOIN categories c ON c.id = p_c_s.category_id LEFT JOIN subcategories s ON s.id = p_c_s.subcategory_id WHERE p.id = $id GROUP BY p.id";

        return DB::select(DB::raw($sql));
    }

    /**
     * Updates product
     *
     * @param $id - product id
     * @param $data - array with info about this product
     * @return true or false
    */
    public function update(int $id, array $data)
    {
        DB::beginTransaction();

        try {        
            DB::table('products')->where('id', $id)->update(array(
                'name' => $data['name'],
                'description' => $data['description'],
                'image' => $data['image'],
                'price' => $data['price'],
                'stock_price' => $data['stock_price'],
                'status' => $data['status']
            ));

            DB::table('products_categories_subcategories')->where('product_id', $id)->delete();

            $products_categories_subcategories = $this->create_array_prods_cats_subcats($id, $data['category'], $data['subcategory']);

            DB::table('products_categories_subcategories')->insert($products_categories_subcategories);
        } catch (Exception $e) {
            DB::rollBack();
        }

        DB::commit();
    }

    /**
     * Deletes product
     *
     * @param $id - product id
     * @return true or false
    */
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {            
            DB::table('products')
                ->where('id', $id)
                ->delete();

            DB::table('products_categories_subcategories')
                ->where('product_id', $id)
                ->delete();
        } catch (Exception $e) {
            DB::rollBack();
        }

        DB::commit();
    }

    /**
     * Changes product status
     *
     * @param $id - product id
     * @param $status - product status
     * @return true or false
    */
    public function move(int $id, int $status)
    {
        DB::table('products')->where('id', $id)->update(array(
            'status' => $status
        ));
    }

    /**
     * Gets all product with status = 0
     *
     * @return data products
    */
    public function show_out_stock()
    {
        $sql = "SELECT p.id, p.name, p.description, p.image, p.price, p.status, GROUP_CONCAT(DISTINCT c.name SEPARATOR ', ') AS categories, GROUP_CONCAT(DISTINCT s.name SEPARATOR ', ') AS subcategories FROM products p INNER JOIN products_categories_subcategories p_c_s ON p.id = p_c_s.product_id INNER JOIN categories c ON c.id = p_c_s.category_id LEFT JOIN subcategories s ON s.id = p_c_s.subcategory_id WHERE p.status = 0 GROUP BY p.id";

        return DB::select(DB::raw($sql));
    }

    /**
     * Shows all product by category and/or subcategory
     *
     * @return data products
    */
    public function show_by_cats_subcats(int $id, $subcat_id=NULL)
    {
        if ($subcat_id) {
            $sql = "SELECT p_c_s.product_id, p.id, p.name, p.description, p.image, p.price, p.status FROM products_categories_subcategories p_c_s JOIN products p ON p_c_s.product_id = p.id WHERE $id = p_c_s.category_id AND $subcat_id = p_c_s.subcategory_id GROUP BY p_c_s.product_id";
        } else {
            $sql = "SELECT p_c_s.product_id, p.id, p.name, p.description, p.image, p.price, p.status FROM products_categories_subcategories p_c_s JOIN products p ON p_c_s.product_id = p.id WHERE $id = p_c_s.category_id GROUP BY p_c_s.product_id";

        }

        $products = DB::select(DB::raw($sql));          

        $current_page = 1;
        $per_page = 6;

        if (count($_REQUEST) > 0) {
            $current_page = $_REQUEST['page'];
        }

        $offset = ($current_page * $per_page) - $per_page;
        $current_url = url()->current();
        
        $products = new LengthAwarePaginator(array_slice($products, $offset, $per_page, true), count($products), $per_page, $current_page, ['path' => $current_url]);

        return $products;
    }
}
