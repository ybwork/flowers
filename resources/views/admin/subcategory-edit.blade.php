@extends('layouts.app')

@section('content')
	<div class="uk-container uk-container-expand">
		@if(count($subcategory) > 0)
			@foreach($subcategory as $subcat)
				<form class="uk-padding" action="{{ route('subcategory_update') }}" method="POST">
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

		        	<input type="hidden" name="_method" value="PUT">
		        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		        	<input type="hidden" name="id" value="{{ $subcat->id }}">
				    <fieldset class="uk-fieldset">
				        <div class="uk-margin">
				            <input class="uk-input" name="name" value="{{ $subcat->name }}" placeholder="Name">
				        </div>
			            <div class="uk-margin">
			                <select name="categories[]" class="subcat-select js-example-basic-multiple" multiple="multiple">
	                      		@foreach ($categories as $category)
	                      			{{ $selected = '' }}
	                      			@foreach ($subcat->categories as $sub_cat)
	                          			@if ($category->id == $sub_cat['id'])
	                          			 	{{ $selected = 'selected' }}
	                          			@endif
	                      			@endforeach
	                      			
	                      			<option {{ $selected }} value="{{ $category->id }}">{{ $category->name }}</option>
	                          	@endforeach
			                </select>
			            </div>
				    </fieldset>
					<p uk-margin>
						<a class="uk-button uk-button-default" href="{{ route('admin_subcategories') }}">Cancel</a>
					    <button class="uk-button uk-button-primary">Update</button>
					</p>
				</form>
			@endforeach
		@endif
	</div>
@endsection