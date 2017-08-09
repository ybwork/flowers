@extends('layouts.app')

@section('content')
	<div class="container products">
		<div class="row">
			@foreach($product as $prod)
				<a href="{{ route('show_product', ['id' => $prod->id]) }}">
			        <div class="col-lg-4">
						<img src="{{ $prod->image }}" width="140" height="140">
						<h2>{{ $prod->name }}</h2>
						<h3>Price: ${{ $prod->price }}</h2>
						<p>{{ $prod->description }}</p>
						<p>
							@if(array_key_exists($prod->id, $cart))
								<form id="ajax-form" action="{{ route('product_delete_from_cart') }}" method="POST">
									<input type="hidden" name="_method" value="DELETE">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="product_id" value="{{ $prod->id }}">
									<button id="ajax-button" class="form-group btn-danger" type="submit">Отказаться</button>
								</form>
							@else
								<form id="ajax-form" action="{{ route('product_add_to_cart') }}" method="POST">
									<input type="hidden" name="_method" value="POST">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="product_id" value="{{ $prod->id }}">
									<button id="ajax-button" class="form-group btn-success" type="submit">Заказать</button>
								</form>
							@endif
						</p>
			        </div>
			    </a>
			@endforeach
	    </div>
	</div>
@endsection