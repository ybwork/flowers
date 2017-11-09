@extends('layouts.app')

@section('content')
    <div class="uk-container uk-container-expand">
        @if(count($products) > 0) 
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
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" uk-icon="icon: arrow-left"></button>  
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