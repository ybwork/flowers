@extends('layouts.app')
	@section('content')
		        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                
        @if(count($products) != 0)    
          <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Photo</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Status</th>
                    <th style="min-width: 80px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                  <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td><img src="{{ $product->image }}" class="img-rounded" alt="Cinque Terre" width="304" height="236"></td>
                    <td>{{ $product->price }}</td>
                    <td>
                        <?php
                            // $category_name = '';
                            // $categories = explode(',', $product->categories);
                            // dd($categories);
                            // foreach ($categories as $category) {
                            //     $category_name .= substr(trim($category), 1);
                            // }
                        ?>
                        {{ $product->categories }}
                    </td>
                    <td>{{ $product->subcategories }}</td>
                    <td>{{ $product->status }}</td>
                    <td>
                        <form class="table-action-btn" action="{{ route('admin_product_move') }}" method="POST">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="status" value="1">
                            <button type="submit" class="fa fa-close del-subcat">Есть на складе</button>  
                        </form>

                        <a href="{{ route('product_edit', ['id' => $product->id]) }}" class="table-action-btn"><i class="fa fa-pencil"></i></a>

                        <form class="table-action-btn" action="{{ route('product_delete') }}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="image_path" value="{{ $product->image }}">
                            <button type="submit" class="fa fa-close del-subcat"></button>  
                        </form>
                    </td>
                  </tr>
                @endforeach
            </tbody>
          </table>
        @endif

            </div>
        </div>
    </div>
</div>
	@endsection