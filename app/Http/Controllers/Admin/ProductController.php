<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use File, Storage;

class ProductController extends Controller
{
	protected $categories;
    protected $subcategories;
	protected $product;

	public function __construct(Category $category, Subcategory $subcategory, Product $product)
	{
		$this->categories = $category;
		$this->subcategories = $subcategory;
        $this->product = $product;
	}

    public function index(Product $product)
    {
		$categories = $this->categories->get_categories();								
		$subcategories = $this->subcategories->get_subcategories();
		// $products = $product->get_products();

    	return view('admin.product', [
    		'categories' => $categories,
    		'subcategories' => $subcategories,
    		// 'products' => $products
    	]);
    }

    public function create(Request $request)
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
            'price' => 'required',
            'category' => 'required',
            'status' => 'required',
        ]);

        $image_name = $request->file('image')->getClientOriginalName();
        $image_path = '/img/products/' . $image_name;

        $data = [];
        $data['name'] = $request['name'];
        $data['description'] = $request['description'];
        $data['image'] = $image_path;
        $data['price'] = $request['price'];
        $data['category'] = $request['category'];
        $data['subcategory'] = $request['subcategory'];
        $data['status'] = $request['status'];

        // dd($image_name);
        $image_content = File::get($request->file('image'));

        if (Storage::exists($image_name)) {
            return redirect()
                        ->back()
                        ->with('message', 'Файл с этим именем уже существует');
        } else {
            Storage::disk('local')->put($image_name, $image_content);
        }

        // dd($image_path);

        // To correctly output a category name in a template (if category several)
        // if ($request['category']) {
        //     $category = implode(', ', $request['category']);
        // } else {
        //     $category = $request['category'];
        // }

        // To correctly output a subcategory name in a template (if subcategory several)
        // if ($request['subcategory']) {
        //     $subcategory = implode(', ', $request['subcategory']);
        // } else {
        //     $subcategory = $request['subcategory'];
        // }
        // dd($category, $subcategory);
        $this->product->create($data);

        return redirect()->back();
    }
}
