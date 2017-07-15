@extends('layouts.app')

@section('content')
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-md-6">
                                	@foreach($errors->all() as $error)
										<p>{{ $error }}</p>
									@endforeach

                                    @if(Session::has('message'))
                                        <p>{{ Session::get('message') }}</p>
                                    @endif

                                <form class="form-horizontal" role="form" enctype="multipart/form-data" action="{{ route('product_create') }}" method="POST">
                                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group">
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-10">
                                                <textarea class="form-control" name="description" value="{{ old('description') }}" placeholder="description"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-10">
                                                <input type="file" name="image" value="200" class="form-control">
                                            </div>
                                        </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <div class="col-md-10">
                                                <input type="number" step="any" name="price" value="{{ old('price') }}" class="form-control" placeholder="price">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <select name="category[]" class="js-example-basic-multiple col-md-8" multiple="multiple">
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-10">
                                              <select name="subcategory[]" class="js-example-basic-multiple col-md-8" multiple="multiple">
	                                                @foreach($subcategories as $subcategory)
	                                                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
	                                                @endforeach
                                              </select>
                                            </div>
                                          </div>

                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <select name="status" class="form-control">
                                                    <option value="">Status</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                        </div>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <hr/>
                                <div class="text-center p-20">
                                     <button type="submit" class="col-sm-12 btn w-sm btn-success waves-effect waves-light">Add</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
                
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