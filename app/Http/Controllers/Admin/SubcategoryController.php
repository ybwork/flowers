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
    	$categories = $category->getCategories();
    	$subcategories = $this->subcategory->getSubcategories();

    	return view('admin.subcategory', [
    		'subcategories' => $subcategories,
    		'categories' => $categories
    	]);
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'categories' => 'required',
    		'name' => 'required'
    	]);

    	$categories = $request['categories'];
    	$name = $request['name'];
    	$this->subcategory->store($categories, $name);

    	return redirect()->back()->with('message', 'Подкатегория добавлена');
    }
}
