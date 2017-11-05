@extends('layouts.app')

@section('content')

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
            	@foreach ($errors->all() as $error)
					<p>{{ $error }}</p>
				@endforeach

				@if (Session::has('message'))
					<p>{{ Session::get('message') }}</p>
				@endif

                <form action="{{ route('category_update') }}" method="POST">
					<input type="hidden" name="_method" value="PUT">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" value="{{ $id }}">
                    <div class="row">
                        <div class="col-sm-12">
                            <section>
                                <div class="form-group clearfix">
                                    <div class="col-lg-9">
                                        <input class="form-control required" id="userName" type="text" name="name" value="{{ $name }}">
                                    </div>
	                                 <a class="btn w-sm btn-white waves-effect" href="{{ route('admin_categories') }}">Cancel</a>
	                                 <button type="submit" class="btn w-sm btn-default waves-effect waves-light">Save</button>
	                            </div>
                            </section>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop