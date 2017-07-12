@extends('layouts.app')

@section('content')
<div class="wrapper">
	        <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                        	@foreach ($errors->all() as $error)
								<p>{{ $error }}</p>
							@endforeach

							@if (Session::has('message'))
								<p>{{ Session::get('message') }}</p>
							@endif

                            <form id="basic-form" action="{{ route('category_create') }}" method="POST">
                               	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div>
                                    <section>
                                        <div class="form-group clearfix">
                                            <div class="col-lg-10">
	                                                <input class="form-control required" id="userName" name="name" type="text" value="{{ old('name') }}" placeholder="category">
                                            </div>
	                                        <button type="submit" class="btn btn-default waves-effect waves-light btn-md">Add category</button>
                                        </div>
                                    </section>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
	            <div class="row">
	                <div class="col-lg-12">
	                	@if(count($categories) != 0)
	                    <div class="card-box">
	                        <div class="table-responsive">
	                            <table class="table table-actions-bar">
	                                <thead>
	                                    <tr>
	                                        <th>Name</th>
	                                        <th style="min-width: 80px;">Action</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
									@foreach($categories as $category)
	                                    <tr>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                            	<a href="{{ route('category_edit', ['id' => $category->id, 'name' => $category->name]) }}">
                                            		<i class="fa fa-pencil" aria-hidden="true"></i>
                                            	</a>

	                                            <form class="table-action-btn" action="{{ route('category_delete') }}" method="POST">
													<input type="hidden" name="_method" value="DELETE">
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<input type="hidden" name="id" value="{{ $category->id }}">
													<button type="submit" class="fa fa-close del-subcat"></button>
												</form>
                                            </td>
	                                    </tr>
									@endforeach
	                                </tbody>
	                            </table>
	                        </div>
	                    </div>
	                </div>
	                @endif
	        </div>
	    </div>
@stop