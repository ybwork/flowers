@extends('layouts.app')

@section('content')
	<div class="container products">
		<div class="row">
			@foreach($products as $product)
				<a href="{{ route('show_product', ['id' => $product->id]) }}">
			        <div class="col-lg-4">
						<img src="{{ $product->image }}" width="140" height="140">
						<h2>{{ $product->name }}</h2>
						<h3>Price: ${{ $product->price }}</h2>
						<p>{{ $product->description }}</p>
						<p>
							@if(array_key_exists($product->id, $cart))
								<form id="ajax-form" action="{{ route('product_delete_from_cart') }}" method="POST">
									<input type="hidden" name="_method" value="DELETE">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="product_id" value="{{ $product->id }}">
									<button id="ajax-button" class="form-group btn-danger" type="submit">Отказаться</button>
								</form>
							@else
								<form id="ajax-form" action="{{ route('product_add_to_cart') }}" method="POST">
									<input type="hidden" name="_method" value="POST">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="product_id" value="{{ $product->id }}">
									<button id="ajax-button" class="form-group btn-success" type="submit">Заказать</button>
								</form>
							@endif
						</p>
			        </div>
			    </a>
			@endforeach
			
			{{ $products->links() }}
	    </div>
	</div>
@endsection