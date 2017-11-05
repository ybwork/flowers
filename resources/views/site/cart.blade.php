@extends('layouts.app')

@section('content')
	@if(count($products) != 0)
		<div class="uk-container uk-container-expand">
			<div class="uk-child-width-1-3@s uk-grid-match uk-padding" uk-grid>
				<form class="ajax-form uk-form-horizontal" action="{{ route('order_create') }}" method="POST">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					@foreach($products as $key => $product)
						<input class="product-id" type="hidden" name="product_id[]" value="{{ $product->id }}">
					    <div>
					        <div class="uk-card uk-card-default uk-card-hover uk-card-body">
					            <h3 class="uk-card-title"><a class="uk-link-reset" href="{{ route('show_product', ['id' => $product->id]) }}">{{ $product->name }}</a></h3>
								<div class="uk-cover-container">
								    <canvas width="140" height="140"></canvas>
								    <img src="{{ $product->image }}" alt="" uk-cover>
								</div>
					            <p>{{ $product->description }}</p>
					            
				            	@if ($product->stock_price)
									<p class="stock">Акция: {{ $product->stock_price }} $</p>
								@else
									<p>{{ $product->price }} $</p>
								@endif
								
								<label class="uk-input uk-form-success uk-form-width-small">+</label>
									<input type="number" name="count[]" class="input-sm quantity-product" value="1">
								<label class="uk-input uk-form-danger uk-form-width-small">-</label>
					        </div>
					    </div>
					@endforeach
					<button class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom ajax-button" type="submit">Оформить</button>
				</form>
			</div>
		</div>
	@endif
@endsection