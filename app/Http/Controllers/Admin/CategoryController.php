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

    public function index()
    {
    	$categories = $this->category->get_categories();
        // dd($categories);
        
    	return view('admin.category', [
    		'categories' => $categories
    	]);
    }

    public function create(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required'
    	]);

    	$name = $request['name'];
    	$this->category->create($name);

    	return redirect()->back()->with('message', 'Категория добавлена');
    }

    public function edit($id, $name)
    {
    	return view('admin.category_edit', [
    		'id' => $id,
    		'name' => $name
    	]);
    }

    public function update(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required'
    	]);

    	$id = $request['id'];
    	$name = $request['name'];
    	$this->category->update($id, $name);

    	return redirect(route('admin_categories'))->with('message', 'Категория обновлена');
    }

    public function delete(Request $request)
    {
    	$id = $request['id'];
    	$this->category->delete($id);
        // dd($result);
        // if ($result) {
        //     $message = 'Категория удалена';
        // } else {
        //     $message = 'Категория не может быть удалена, так как имеет связи с продуктами и подкатегориями';
        //     $message = 'Что то пошло не так, попробуйте позже';
        // }

    	return redirect(route('admin_categories'))->with('message', 'Категория удалена');
    }
}
