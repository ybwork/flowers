@extends('layouts.app')

@section('content')
	<div class="container products">
		<div class="row">
			@foreach($products as $product)
				<a href="{{ route('show_product', ['id' => $product->id]) }}">
			        <div class="col-lg-4">
						<img src="{{ $product->image }}" width="140" height="140">
						<h2>{{ $product->name }}</h2>
						<h4 class="product-price">{{ $product->price }} руб.</h4>
						@if ($product->stock_price)
							<h3 class="stock">Акция: {{ $product->stock_price }} руб.</h3>
						@endif
						<p>{{ $product->description }}</p>
						<p>
							@if(array_key_exists($product->id, $cart))
								<form class="ajax-form" action="{{ route('product_delete_from_cart') }}" method="POST">
									<input type="hidden" name="_method" value="DELETE">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="product_id" value="{{ $product->id }}">
									<button class="form-group btn-danger ajax-button" type="submit">Отказаться</button>
								</form>
							@else
								<form class="ajax-form" action="{{ route('product_add_to_cart') }}" method="POST">
									<input type="hidden" name="_method" value="POST">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="product_id" value="{{ $product->id }}">
									<button class="form-group btn-success ajax-button" type="submit">Заказать</button>
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