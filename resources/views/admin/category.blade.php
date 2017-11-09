@extends('layouts.app')

@section('content')
	<div class="uk-container uk-container-expand">
		<form class="uk-padding" action="{{ route('category_create') }}" method="POST">
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

			<input type="hidden" name="_token" value="{{ csrf_token() }}">
		    <fieldset class="uk-fieldset">
		        <div class="uk-margin">
		            <input class="uk-input" type="text" name="name" value="{{ old('name') }}" placeholder="Name">
		        </div>
		    </fieldset>
		    <button class="uk-button uk-button-default uk-width-1-1 uk-margin-small-bottom">Add</button>
		</form>

		@if(count($categories) > 0)
			<table class="uk-table uk-table-hover uk-table-divider">
			    <thead>
			        <tr>
			            <th>Category</th>
			            <th>Actions</th>
			        </tr>
			    </thead>
			    <tbody>
			        @foreach($categories as $category)
				        <tr>
				            <td>{{ $category->name }}</td>
				            <td>
				            <a href="{{ route('category_edit', ['id' => $category->id, 'name' => $category->name]) }}" uk-icon="icon: pencil"></a>

	                        <form class="table-action-btn" action="{{ route('category_delete') }}" method="POST">
								<input type="hidden" name="_method" value="DELETE">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="id" value="{{ $category->id }}">
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