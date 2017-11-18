<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;

class SubcategoryController extends Controller
{
    protected $subcategory;
    protected $category;

    /**
     * Sets models
     */
    public function __construct(Subcategory $subcategory, Category $category)
    {
    	$this->subcategory = $subcategory;
        $this->category = $category;
    }

    /**
     * Shows all subcategories
     *
     * @return html view
     */
    public function index()
    {
    	$categories = $this->category->get_categories();
        $subcategories = $this->subcategory->get_subcategories();

    	return view('admin.subcategory', [
            'categories' => $categories,
    		'subcategories' => $subcategories,
    	]);
    }

    /**
     * Collect data for create subcategory
     * 
     * @param Request $request - object with data from form
     * @return redirect on home page subcategories
     */
    public function create(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required',
            'categories' => 'required',
    	]);

        $name = (string) $request['name'];
    	$categories = (array) $request['categories'];

    	$this->subcategory->create($name, $categories);

    	return redirect()->back()->with('message', 'Success');
    }

    /**
     * Show subcategory which need edit
     *
     * @param $id - id subcategory
     * @return html view
     */
    public function edit($id)
    {
        $subcategory_id = (int) $id;

        $subcategory = $this->subcategory->show($subcategory_id);
        $categories = $this->category->get_categories();

        // For correct display in selec2.js
        foreach ($subcategory as $subcat) {
            $cats = explode(',', $subcat->categories);

            $arr = [];

            foreach ($cats as $key => $cat) {
                $cat_id = preg_replace("/[^0-9]/", '', $cat);
                $cat_name = preg_replace('/\d/','', $cat);

                $arr[$key] = [];
                $arr[$key]['id'] = $cat_id;
                $arr[$key]['name'] = $cat_name;
            }

            $subcat->categories = $arr;
        }

        return view('admin.subcategory-edit', [
            'subcategory' => $subcategory,
            'categories' => $categories,
        ]);
    }

    /**
     * Collect data for update subcategory
     *
     * @param Request $request - object with data from form
     * @return redirect on home page subcategories
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'categories' => 'required',     
        ]);
        
        $id = (int) $request['id'];
        $name = (string) $request['name'];
        $categories = (array) $request['categories'];
      
        $result = $this->subcategory->update($id, $name, $categories);


        return redirect(route('admin_subcategories'))->with('message', 'Success');
    }

    /**
     * Collect data for delete subcategory
     *
     * @param Request $request - object with data from form
     * @return redirect on home page subcategories
     */
    public function delete(Request $request)
    {   
        $id = (int) $request->id;

        $this->subcategory->delete($id);

        return redirect()->back()->with('message', 'Success');
    }
}
