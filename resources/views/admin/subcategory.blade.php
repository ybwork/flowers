@extends('layouts.app')

@section('content')
	@foreach($errors->all() as $error)
		<p>{{ $error }}</p>
	@endforeach

	@if(Session::has('message'))
		<p>{{ Session::get('message') }}</p>
	@endif
              
    <form action="{{ route('subcategory_create') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-lg-2">
            <select name="categories[]" class="form-control js-example-basic-multiple" multiple="multiple">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <input type="text" name="name" value="{{ old('name') }}">
        <button type="submit">Add</button>
    </form>

    <div class="row">
        <div class="col-lg-12">
            @if(count($subcategories) != 0)
                <div class="card-box">
                    <div class="table-responsive">
                        <table class="table table-actions-bar">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Parent categories</th>
                                    <th style="min-width: 80px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subcategories as $subcats)
                                    <tr>
                                        <td>{{ $subcats->name }}</td>
                                        <td>
                                            {{ preg_replace('/[0-9]+/', '', $subcats->categories) }}
                                        </td>
                                        <td>
                                            <a href="{{ route('subcategory_edit', ['id' => $subcats->id]) }}">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>
                                            <form class="table-action-btn" action="{{ route('subcategory_delete') }}" method="POST">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="id" value="{{ $subcats->id }}">
                                                <button type="submit" class="fa fa-close del-subcat"></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop