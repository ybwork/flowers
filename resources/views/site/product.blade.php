@extends('layouts.app')

@section('content')
	<div class="uk-container uk-container-expand">
		<div class="uk-child-width-1-3@s uk-grid-match uk-padding" uk-grid>
			@if(count($product) > 0)
				@foreach($product as $prod)
					<div class="uk-align-center">
				        <div class="uk-card uk-card-default uk-card-hover uk-card-body">
				            <h3 class="uk-card-title"><a class="uk-link-reset" href="{{ route('show_product', ['id' => $prod->id]) }}">{{ $prod->name }}</a></h3>
							<div class="uk-cover-container">
							    <canvas width="140" height="140"></canvas>
							    <img src="{{ $prod->image }}" alt="" uk-cover>
							</div>
				            <p>{{ $prod->description }}</p>
				            
			            	@if ($prod->stock_price)
								<p class="stock">Акция: {{ $prod->stock_price }} $</p>
							@else
								<p>{{ $prod->price }} $</p>
							@endif

							@if(array_key_exists($prod->id, $cart))
								<form class="ajax-form" action="{{ route('product_delete_from_cart') }}" method="POST">
									<input type="hidden" name="_method" value="DELETE">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="product_id" value="{{ $prod->id }}">
									<button class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom ajax-button" type="submit">Отказаться</button>
								</form>
							@else
								<form class="ajax-form" action="{{ route('product_add_to_cart') }}" method="POST">
									<input type="hidden" name="_method" value="POST">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="product_id" value="{{ $prod->id }}">
									<button class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom ajax-button" type="submit">Заказать</button>
								</form>
							@endif
				        </div>
				    </div>
				@endforeach
			@endif
		</div>
	</div>
@endsection