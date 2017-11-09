@extends('layouts.app')

@section('content')
    <div class="uk-container uk-container-expand">
        @if(count($product) > 0)
            @foreach($product as $prod)
                <form class="uk-padding" enctype="multipart/form-data" action="{{ route('product_update') }}" method="POST">
                    @if(Session::has('message'))
                        <div class="uk-alert-success" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p>{{ Session::get('message') }}</p>
                        </div>
                    @endif

                    @foreach($errors->all() as $error)
                        <div class="uk-alert-danger" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p>{{ $error }}</p>
                        </div>
                    @endforeach

                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="old_image_path" value="{{ $prod->image }}">
                    <input type="hidden" name="id" value="{{ $prod->id }}">
                    <fieldset class="uk-fieldset">
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-horizontal-select">Name</label>
                            <input class="uk-input" type="text" name="name" value="{{ $prod->name }}">
                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-horizontal-select">Description</label>
                            <textarea class="uk-input" name="description">{{ $prod->description }}</textarea>
                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-horizontal-select">Price</label>
                            <input class="uk-input" type="number" min="1" step="any" name="price" value="{{ $prod->price }}">
                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-horizontal-select">Stock price</label>
                            <input class="uk-input" type="number" min="1" step="any" name="stock_price" value="{{ $prod->stock_price }}">
                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-horizontal-select">Categories</label>
                            <select name="category[]" class="subcat-select js-example-basic-multiple" multiple="multiple">
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

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-horizontal-select">Subcategories</label>
                            <select name="subcategory[]" class="subcat-select js-example-basic-multiple" multiple="multiple">
                                <?php $subcats = explode(',', $prod->subcategories); ?>
                                <?php foreach ($subcategories as $subcategory): ?>
                                    <?php $selected = ''; ?>
                                    <?php foreach ($subcats as $subcat): ?>
                                        <?php if ($subcategory->id == (int) filter_var($subcat, FILTER_SANITIZE_NUMBER_INT)): ?>
                                            <?php $selected = 'selected'; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                        <option {{ $selected }} value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-horizontal-select">Status</label>
                            <div class="uk-form-controls">
                                <select name="status" class="uk-select" id="form-horizontal-select">
                                    <?php
                                        $status_yes = '';
                                        $status_no = '';

                                        if ($prod->status) {
                                            $status_yes = 'selected';
                                        } else {
                                            $status_no = 'selected';
                                        }
                                    ?>
                                    <option <?php print $status_yes; ?> value="1">Yes</option>
                                    <option <?php print $status_no; ?> value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <img class="uk-preserve-width uk-border-circle" src="{{ $prod->image }}" width="40" alt="">

                        <div class="uk-margin" uk-margin>
                            <div uk-form-custom="target: true">
                                <input type="file" name="image" value="200">
                                <input class="uk-input uk-form-width-medium" type="text" placeholder="image" disabled>
                            </div>
                        </div>
                    </fieldset>
                    <p uk-margin>
                        <a class="uk-button uk-button-default" href="{{ route('admin_products') }}">Cancel</a>
                        <button class="uk-button uk-button-primary">Update</button>
                    </p>
                </form>
            @endforeach
        @endif
    </div>
@endsection