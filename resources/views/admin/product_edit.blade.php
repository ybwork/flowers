@extends('layouts.app')

@section('content')

<div class="wrapper">
    <div class="container">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach

        @if(Session::has('message'))
            <p>{{ Session::get('message') }}</p>
        @endif

        @foreach ($product as $prod)
        <form class="form-horizontal" role="form" enctype="multipart/form-data" action="{{ route('product_update') }}" method="POST">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="old_image_path" value="{{ $prod->image }}">
            <div class="form-horizontal">
                <div class="col-md-6">
                        <input type="hidden" name="id" value="{{ $prod->id }}">
                        <div class="form-group">
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="name" value="{{ $prod->name }}" placeholder="name">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10">
                                <textarea class="form-control" name="description" placeholder="description">{{ $prod->description }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10">
                                <img src="{{ $prod->image }}" height="62" width="62">    
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10">
                                <input type="file" name="image" class="custom-file-input">    
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-md-10">
                                <input type="number" step="any" name="price" value="{{ $prod->price }}" class="form-control" placeholder="price">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10">
                                <input type="number" step="any" name="stock_price" value="{{ $prod->stock_price }}" class="form-control" placeholder="stock price">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10">
                                <select name="category[]" class="js-example-basic-multiple col-md-8" multiple="multiple">
                                    <?php $cats = explode(',', $prod->categories); ?>
                                    <?php foreach ($categories as $category): ?>
                                        <?php $selected = ''; ?>
                                        <?php foreach ($cats as $cat): ?>
                                            <?php if ($category->id == preg_replace('/[^A-Za-z0-9\-]+/', '', $cat)): ?>
                                                <?php $selected = 'selected'; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                            <option {{ $selected }} value="{{ $category->id }}">{{ $category->name }}</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10">
                              <select name="subcategory[]" class="js-example-basic-multiple col-md-8" multiple="multiple">
                                    <?php $subcats = explode(',', $prod->subcategories); ?>
                                    <?php foreach ($subcategories as $subcategory): ?>
                                        <?php $selected = ''; ?>
                                        <?php foreach ($subcats as $subcat): ?>
                                            <?php if ($subcategory->id == substr($subcat, 0, 1)): ?>
                                                <?php $selected = 'selected'; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                            <option {{ $selected }} value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                    <?php endforeach; ?>
                              </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10">
                                <select name="status" class="form-control">
                                    <?php
                                        $status_yes = '';
                                        $status_no = '';

                                        if ($prod->status) {
                                            $status_yes = 'selected';
                                        } else {
                                            $status_no = 'selected';
                                        }
                                    ?>
                                    <option value=""></option>
                                    <option <?php print $status_yes; ?> value="1">Yes</option>
                                    <option <?php print $status_no; ?> value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="row">
                <div class="col-sm-12">
                    <hr/>
                    <div class="text-center p-20">
                        <a href="{{ route('admin_products') }}" class="btn w-sm btn-white waves-effect">Отмена</a>
                        <button type="submit" class="btn w-sm btn-default waves-effect waves-light">Обновить</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@stop