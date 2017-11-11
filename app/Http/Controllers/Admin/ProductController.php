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

    /**
     * Shows home page product
     *
     * @return html view home page products
     */
    public function index()
    {
        $categories = $this->categories->get_categories();
        $subcategories = $this->subcategories->get_subcategories();
        $products = $this->product->get_products();

    	return view('admin.product', [
    		'categories' => $categories,
    		'subcategories' => $subcategories,
    		'products' => $products
    	]);
    }

    /**
     * Creates product
     *
     * @param Request $request - object with data from form
     * @return redirect on home page products
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|max:200|unique:products,image',
            'price' => 'required',
            'category' => 'required',
            'status' => 'required',
        ]);

        $image_type = substr($request->file('image')->getMimeType(), strpos($request->file('image')->getMimeType(), '/') + 1);
        $image_name = uniqid() . ".$image_type";
        $image_path = '/img/products/' . $image_name;

        $image_content = File::get($request->file('image'));
        Storage::disk('local')->put($image_name, $image_content);

        $data = [];
        $data['name'] = $request['name'];
        $data['description'] = $request['description'];
        $data['image'] = $image_path;
        $data['price'] = $request['price'];
        $data['stock_price'] = $request['stock_price'];
        $data['category'] = $request['category'];
        $data['subcategory'] = $request['subcategory'];
        $data['status'] = $request['status'];

        $this->product->create($data);

        return redirect()->back()->with('message', 'Success');
    }

    /**
     * Shows data product which need edit
     *
     * @param $id - unique id product
     * @return html view for edit product
     */
    public function edit($id)
    {
        $categories = $this->categories->get_categories();                              
        $subcategories = $this->subcategories->get_subcategories();

        $product_id = (int) $id;
        $product = $this->product->show($id);

        return view('admin.product-edit', [
            'categories' => $categories, 
            'subcategories' => $subcategories,
            'product' => $product, 
        ]);
    }

    /**
     * Updates product
     *
     * @param Request $request -  object with data from form
     * @return redirect on home page products
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'image' => 'image|max:200|unique:products,image',
            'price' => 'required',
            'category' => 'required',
            'status' => 'required'
        ]);

        if ($request->file('image')) {
            $image_type = substr($request->file('image')->getMimeType(), strpos($request->file('image')->getMimeType(), '/') + 1);
            $image_name = uniqid() . ".$image_type";
            $image_content = File::get($request->file('image'));
        } else {
            $image_name = '';
        }

        $old_image_path = explode('/', $request['old_image_path']);
        $old_image = array_pop($old_image_path);

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

        $id = (int) $request['id'];

        $data['name'] = $request['name'];
        $data['description'] = $request['description'];
        $data['image'] = '/img/products/' . $image_name;
        $data['price'] = $request['price'];
        $data['stock_price'] = $request['stock_price'];
        $data['category'] = $request['category'];
        $data['subcategory'] = $request['subcategory'];
        $data['status'] = $request['status'];

        $this->product->update($id, $data);

        return redirect(route('admin_products'))->with('message', 'Success');
    }

    /**
     * Delete product
     *
     * @param Request $request - object with data from form
     * @return redirect on home page products
     */
    public function delete(Request $request)
    {
        $id = (int) $request['id'];
        $this->product->delete($id);

        $image_path = explode('/', $request['image_path']);
        $image = array_pop($image_path);
        Storage::delete($image);

        return redirect()->back()->with('message', 'Success');
    }

    /**
     * Moves product if him ended on stock
     *
     * @param Request $request - object with data from form
     * @return redirect on home page products
     */
    public function move(Request $request)
    {
        $id = (int) $request['id'];
        $status = (int) $request['status'];

        $this->product->move($id, $status);

        return redirect()->back()->with('message', 'Success');
    }

    /**
     * Shows products which ended on stock 
     *
     * @return html view products which ended on stock
     */
    public function show_out_stock()
    {
        $products = $this->product->show_out_stock();

        return view('admin.product-out-stock', [
            'products' => $products,
        ]);
    }
}
