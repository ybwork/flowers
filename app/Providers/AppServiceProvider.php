<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Category $category)
    {
        $categories_subcategories = $category->get_categories();

        foreach ($categories_subcategories as $cat_subcat) {
            $subcategories = explode(',', $cat_subcat->subcategories);

            $arr = [];

            foreach ($subcategories as $key => $subcat) {
                $subcat_id = preg_replace("/[^0-9]/", '', $subcat);
                $subcat_name = preg_replace('/\d/','', $subcat);

                $arr[$key] = [];
                $arr[$key]['id'] = $subcat_id;
                $arr[$key]['name'] = $subcat_name;
            }

            $cat_subcat->subcategories = $arr;
        }

        View::share('categories_subcategories', $categories_subcategories);
        // dd($categories_subcategories);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
