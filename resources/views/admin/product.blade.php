@extends('layouts.app')

@section('content')
<div class="uk-container uk-container-expand">
    <form class="uk-padding" enctype="multipart/form-data" action="{{ route('product_create') }}" method="POST">
        @if (Session::has('message'))
            <div class="uk-alert-success" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>{{ Session::get('message') }}</p>
            </div>
        @endif

        @foreach ($errors->all() as $error)
            <div class="uk-alert-danger" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>{{ $error }}</p>
            </div>
        @endforeach

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <fieldset class="uk-fieldset">
            <div class="uk-margin">
                <label class="uk-form-label" for="form-horizontal-select">Name</label>
                <input class="uk-input" type="text" name="name" value="{{ old('name') }}">
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-horizontal-select">Description</label>
                <textarea class="uk-input" name="description">{{ old('description') }}</textarea>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-horizontal-select">Price</label>
                <input class="uk-input" type="number" min="1" step="any" name="price" value="{{ old('price') }}">
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-horizontal-select">Stock price</label>
                <input class="uk-input" type="number" min="1" step="any" name="stock_price" value="{{ old('stock_price') }}">
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-horizontal-select">Categories</label>
                <select name="category[]" class="subcat-select js-example-basic-multiple" multiple="multiple">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-horizontal-select">Subcategories</label>
                <select name="subcategory[]" class="subcat-select js-example-basic-multiple" multiple="multiple">
                    @foreach($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-horizontal-select">Status</label>
                <div class="uk-form-controls">
                    <select name="status" class="uk-select" id="form-horizontal-select">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>

            <div class="uk-margin" uk-margin>
                <div uk-form-custom="target: true">
                    <input type="file" name="image" value="200">
                    <input class="uk-input uk-form-width-medium" type="text" placeholder="image" disabled>
                </div>
            </div>
        </fieldset>
        <button class="uk-button uk-button-default uk-width-1-1 uk-margin-small-bottom">Add</button>
    </form>
    
    @if(count($products) != 0) 
        <table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
            <thead>
                <tr>
                    <th class="uk-table-shrink">Product</th>
                    <th class="uk-table-shrink">Image</th>
                    <th class="uk-table-expand">Description</th>
                    <th class="uk-width-small">Price</th>
                    <th class="uk-table-shrink uk-text-nowrap">Stock price</th>
                    <th class="uk-table-shrink uk-text-nowrap">Categories</th>
                    <th class="uk-table-shrink uk-text-nowrap">Subcategories</th>
                    <th class="uk-table-shrink uk-text-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td><img class="uk-preserve-width uk-border-circle" src="{{ $product->image }}" width="40" alt=""></td>
                        <td>
                            {{ $product->description }}
                        </td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock_price }}</td>
                        <td>{{ $product->categories }}</td>
                        <td>{{ $product->subcategories }}</td>
                        <td>
                            <form class="table-action-btn" action="{{ route('admin_product_move') }}" method="POST">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="status" value="0">
                                <button type="submit" uk-icon="icon: arrow-right"></button>  
                            </form>

                            <a href="{{ route('product_edit', ['id' => $product->id]) }}" class="table-action-btn" uk-icon="icon: pencil"></a>

                            <form action="{{ route('product_delete') }}" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="image_path" value="{{ $product->image }}">
                                <button type="submit" uk-icon="icon: trash"></button>  
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection