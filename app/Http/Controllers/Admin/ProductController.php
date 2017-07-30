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

    public function index()
    {
		$categories = $this->categories->get_categories();
		$subcategories = $this->subcategories->get_subcategories();
		$products = $this->product->get_products();
        // dd($products);
    	return view('admin.product', [
    		'categories' => $categories,
    		'subcategories' => $subcategories,
    		'products' => $products
    	]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
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

        $this->product->create($data);

        return redirect()->back()->with('message', 'Товар создан!');
    }

    public function edit(Request $request, $id)
    {
        $categories = $this->categories->get_categories();                              
        $subcategories = $this->subcategories->get_subcategories();
        $product = $this->product->show($id);
        // dd($product);
        return view('admin.product_edit', [
            'categories' => $categories, 
            'subcategories' => $subcategories,
            'product' => $product, 
        ]);
    }

    public function update(Request $request, Product $product)
    {
        // dd($request);
        // 'image' => 'required|image|max:200|unique:products,image',
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'image' => 'image|max:200|unique:products,image',
            'price' => 'required',
            'category' => 'required',
            'status' => 'required'
        ]);

        if ($request->file('image')) {
            $image_name = $request->file('image')->getClientOriginalName();
            // dd($image_name);
            $image_content = File::get($request->file('image'));
        } else {
            $image_name = '';
        }

        $old_image_path = explode('/', $request['old_image_path']);
        $old_image = array_pop($old_image_path);
        // dd($old_image);
        
        // $image_name = $request->file('image')->getClientOriginalName();
        // $image_content = File::get($request->file('image'));

        // $old_image_path = explode('/', $request['old_image_path']);
        // $old_image = array_pop($old_image_path);

        // if ($image_name == $old_image) {
        //     goto end;
        // } elseif (!Storage::exists($image_name)) {
        //     Storage::delete($old_image);
        //     Storage::disk('local')->put($image_name, $image_content);
        // } else {
        //     return redirect()
        //                 ->back()
        //                 ->with('message', 'Файл с этим именем уже существует');
        // }

        // end:

        // $data = [];
        // $data['id'] = $request['id'];
        // $data['name'] = $request['name'];
        // $data['description'] = $request['description'];
        // $data['image'] = '/img/products/' . $image_name;
        // $data['price'] = $request['price'];
        // $data['category'] = $request['category'];
        // $data['subcategory'] = $request['subcategory'];
        // $data['status'] = $request['status'];


        if (Storage::exists($image_name)) {
            return redirect()
                        ->back()
                        ->with('message', 'Файл с этим именем уже существует');
        } elseif (!$image_name) {
            $image_name = $old_image;
        } else {
            Storage::delete($old_image);
            Storage::disk('local')->put($image_name, $image_content);
        }

        $data = [];
        $data['id'] = $request['id'];
        $data['name'] = $request['name'];
        $data['description'] = $request['description'];
        $data['image'] = '/img/products/' . $image_name;
        $data['price'] = $request['price'];
        $data['category'] = $request['category'];
        $data['subcategory'] = $request['subcategory'];
        $data['status'] = $request['status'];

        $this->product->update($data);

        return redirect(route('admin_products'))->with('message', 'Продукт обновлен');
    }

    public function delete(Request $request, Product $product)
    {
        $image_path = explode('/', $request['image_path']);
        $image = array_pop($image_path);
        Storage::delete($image);

        $id = $request['id'];
        $this->product->delete($id);

        return redirect()->back()->with('message', 'Товар удалён');
    }

    public function move(Request $request)
    {
        $id = $request['id'];
        $status = $request['status'];

        $this->product->move($id, $status);

        return redirect()->back()->with('message', 'Продукт перемещён');
    }

    public function show_out_stock()
    {
        $products = $this->product->show_out_stock();

        return view('admin.product_out_stock', [
            'products' => $products,
        ]);
    }
}
