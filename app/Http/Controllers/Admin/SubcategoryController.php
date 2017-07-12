<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;

class SubcategoryController extends Controller
{
    protected $subcategory;

    public function __construct(Subcategory $subcategory)
    {
    	$this->subcategory = $subcategory;
    }

    public function index(Category $category)
    {
    	$categories = $category->get_categories();
    	$subcategories = $this->subcategory->get_subcategories();
        
    	return view('admin.subcategory', [
            'categories' => $categories,
    		'subcategories' => $subcategories,
    	]);
    }

    public function create(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required',
            'categories' => 'required',
    	]);

        $name = $request['name'];
    	$categories = $request['categories'];

    	$this->subcategory->create($name, $categories);

    	return redirect()->back()->with('message', 'Подкатегория добавлена');
    }

    public function edit($id, Category $category)
    {
        $subcategory = $this->subcategory->show($id);
        $categories = $category->get_categories();
        
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

        return view('admin.subcategory_edit', [
            'subcategory' => $subcategory,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'categories' => 'required',     
        ]);
        
        $id = $request['id'];
        $name = $request['name'];
        $categories = $request['categories'];

        try {        
            $result = $this->subcategory->update($id, $name, $categories);

            if (!$result) {
                throw new Exception('Что то пошло не так, попробуйте позже!');
            } 
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return redirect(route('admin_subcategories'))->with('message', 'Подкатегория обновлена');
    }

    public function delete(Request $request)
    {   
        $id = $request->id;
        $this->subcategory->delete($id);
        return redirect()->back()->with('message', 'Подкатегория удалена');
    }
}
