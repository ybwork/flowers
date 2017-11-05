@extends('layouts.app')

@section('content')
<div class="uk-container uk-container-expand">
	<form class="uk-padding" action="{{ route('category_update') }}" method="POST">
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
		<input type="hidden" name="id" value="{{ $id }}">
	    <fieldset class="uk-fieldset">
	        <div class="uk-margin">
	            <input class="uk-input" type="text" name="name" value="{{ $name }}" placeholder="Name">
	        </div>
	    </fieldset>
		<p uk-margin>
			<a class="uk-button uk-button-default" href="{{ route('admin_categories') }}">Cancel</a>
		    <button class="uk-button uk-button-primary">Update</button>
		</p>
	</form>
</div>
@stop