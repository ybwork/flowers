@extends('layouts.app')

@section('content')
	<div class="uk-margin uk-padding">
		<div class="uk-alert-danger" uk-alert>
		    <p>Something went wrong please try again later. <a href="{{ route('home') }}">Home</a></p>
		</div>
	</div>
@endsection