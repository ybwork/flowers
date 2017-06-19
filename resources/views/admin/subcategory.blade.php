@extends('layouts.app')

@section('content')
	@foreach($errors->all() as $error)
		<p>{{ $error }}</p>
	@endforeach

	@if(Session::has('message'))
		<p>{{ Session::get('message') }}</p>
	@endif
	
	<form action="{{ route('subcategory_store') }}" method="POST">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="col-lg-2">
			<select name="categories[]" class="form-control js-example-basic-multiple" multiple="multiple">
				@foreach($categories as $category)
					<option value="{{ $category->id }}">{{ $category->name }}</option>
				@endforeach
			</select>
		</div>
		<input type="text" name="name">
		<button type="submit">Add</button>
	</form>

	@foreach($subcategories as $subcategory)
		<p>{{ $subcategory->name }}</p>
	@endforeach
@stop