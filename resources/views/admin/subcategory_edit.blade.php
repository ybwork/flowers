@extends('layouts.app')

@section('content')
	<div class="wrapper">
	    <div class="container">
	        <!-- Basic Form Wizard -->
	        <div class="row">
	            <div class="col-md-12">
	                <div class="card-box">
	                	@foreach($errors->all() as $error)
							<p>{{ $error }}</p>
						@endforeach

						@foreach($subcategory as $subcat)
		                    <form action="{{ route('subcategory_update') }}" method="POST">
		                    	<input type="hidden" name="_method" value="PUT">
		                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		                    	<input type="hidden" name="id" value="{{ $subcat->id }}">
		                        <div>
		                            <section>
		                                <div class="form-group clearfix">
		                                    <div class="col-lg-7">
		                                    	<label>Name</label>
		                                        <input class="form-control required" type="text" name="name" value="{{ $subcat->name }}" placeholder="subcategory">
		                                    </div>
		                                    <div class="col-lg-2">
		                                    	<label>Parent categories</label>                 
		                                        <select select name="categories[]" class="form-control js-example-basic-multiple" multiple="multiple">
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
											<a href="{{ route('admin_subcategories') }}" type="button" class="btn w-sm btn-white waves-effect">Cancel</a>
											<button type="submit" class="btn w-sm btn-default waves-effect waves-light">Save</button>
		                                </div>
		                            </section>
		                        </div>
		                    </form>
	                   	@endforeach
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
@stop