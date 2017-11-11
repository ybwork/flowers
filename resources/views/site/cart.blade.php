@extends('layouts.app')

@section('content')
	@if(count($products) > 0)
		<div class="uk-container uk-container-expand">
			<div class="uk-card uk-card-default uk-card-body" style="z-index: 980;" uk-sticky="bottom: #offset">
				<div class="uk-alert-success" uk-alert style="display: none">
				    <a class="uk-alert-close" uk-close></a>
				    <p>Success</p>
				</div>
				<div class="uk-alert-danger" uk-alert style="display: none">
				    <a class="uk-alert-close" uk-close></a>
				    <p>Something went wrong, try again later</p>
				</div>
		   		<h4>The total amount of the order: <strong class="common-price"> {{ $subtotal }}</strong> $.</h4>
		   	</div>
			<form class="order" action="{{ route('order_create') }}" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
					@foreach($products as $key => $product)
					    <div class="uk-margin uk-padding item-<?php print $product->id; ?>">
					        <div class="uk-card uk-card-secondary uk-card-body">
								<input class="product-id" type="hidden" name="product_id[]" value="{{ $product->id }}">
					        	<div class="uk-card-badge uk-label delete-item">
					        		<span uk-icon="icon: close"></span>
					        	</div>
					            <h3 class="uk-card-title">{{ $product->name }}</h3>
					            <p class="product-price">{{ $product->price }} $</p>
					            <span class="minus" uk-icon="icon: minus"></span>

					            <input class="uk-input uk-form-width-medium quantity-product" type="number" name="count[]" value="1">

					            <span class="plus" uk-icon="icon: plus"></span>
					        </div>
					    </div>
				   	@endforeach
				<div class="uk-margin uk-padding">
			   		<button type="submit" class="uk-margin uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom">Buy</button>
			   	</div>
			</form>		
		</div>
	@else
	<div class="uk-margin uk-padding">
		<div class="uk-alert-primary" uk-alert>
		    <p>There are no products in the cart.</p>
		</div>
	</div>
	@endif
@endsection