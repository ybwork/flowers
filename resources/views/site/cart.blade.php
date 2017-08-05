@extends('layouts.app')

@section('content')
	@if(count($products) != 0)
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="panel panel-info">
						@foreach($products as $key => $product)
						<div id="cartItem">
							<form id="deleteItem" class="delete-item" action="{{ route('product_delete_from_cart') }}" method="POST">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="_method" value="DELETE">
								<input id="product_id" class="product_id" type="hidden" name="product_id" value="{{ $product->id }}">

								<div class="panel-body">
									<div class="row">
										<div class="col-xs-2"><img class="img-responsive" src="{{ asset($product->image) }}">
										</div>
										<div class="col-xs-4">
											<h4 class="product-name"><strong>{{ $product->name }}</strong></h4><h4><small>{{ $product->description }}</small></h4>
										</div>
										<div class="col-xs-6">
											<div class="col-xs-6 text-right">
												<h6><strong>{{ $product->price }} руб.</strong></h6>
											</div>
											<div class="col-xs-4">
												<input class="count" type="number" class="form-control input-sm" value="1">
											</div>
										</div>
									</div>
								</div>

								<button type="submit" class="btn btn-danger btn-sm">
									<i class="fa fa-trash-o"></i>
								</button>
							</form>				
						</div>
						@endforeach
					</div>
				</div>
				<div class="col-xs-12">
					<h4><strong>Общая сумма заказа: {{ $subtotal }} руб.</strong></h4>
					<form id="order" action="{{ route('order_create') }}" method="POST">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<button type="submit" class="btn btn-success btn-sm col-md-12">Заказать</button>
					</form>	
				</div>
			</div>
		</div>
	@endif
@endsection