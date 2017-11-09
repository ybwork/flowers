<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Pagination\Paginator;

class CategoryController extends Controller
{
	protected $category;

	public function __construct(Category $category)
	{
		$this->category = $category;
	}

    /**
     * Shows page with names exists categories
     *
     * @return html view home page categories
     */
    public function index()
    {
    	$categories = $this->category->get_categories();
        
    	return view('admin.category', [
    		'categories' => $categories
    	]);
    }

    /**
     * Creates category
     * 
     * @param Request $request - object with data from form
     * @return redirect on home page categories
     */
    public function create(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required'
    	]);

    	$name = (string) $request['name'];

    	$this->category->create($name);

    	return redirect()->back()->with('message', 'Success');
    }

    /**
     * Show category which need edit
     *
     * @param $id - unique id category
     * @param $name = category name
     * @return html view for edit category
    */
    public function edit($id, $name)
    {
    	return view('admin.category-edit', [
    		'id' => $id,
    		'name' => $name
    	]);
    }

    /**
     * Updates category
     *
     * @param Request $request - object with data from form
     * @return redirect on home page categories
    */
    public function update(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required'
    	]);

    	$id = (int) $request['id'];
    	$name = (string) $request['name'];
        
    	$this->category->update($id, $name);

    	return redirect(route('admin_categories'))->with('message', 'Success');
    }

    /**
     * Deletes category
     *
     * @param Request $request - object with data from form
     * @return redirect on home page categories
    */
    public function delete(Request $request)
    {
    	$id = (int) $request['id'];
  
    	$this->category->delete($id);

    	return redirect(route('admin_categories'))->with('message', 'Success');
    }
}
