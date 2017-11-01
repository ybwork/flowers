@extends('layouts.app')

@section('content')
	@if(count($products) != 0)
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="panel panel-info">
							<!-- class="order" -->
							<form  action="{{ route('order_create') }}" method="POST">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
									@foreach($products as $key => $product)
										<div class="panel-body">
											<input class="product-id" type="hidden" name="product_id[]" value="{{ $product->id }}">
											<div class="row">
												<div class="col-xs-2"><img class="img-responsive" src="{{ asset($product->image) }}">
												</div>
												<div class="col-xs-4">
													<h4 class="product-name"><strong>{{ $product->name }}</strong></h4><h4><small>{{ $product->description }}</small></h4>
												</div>
												<div class="col-xs-6">
													<div class="col-xs-6 text-right">
														<h6><strong class="product-price">{{ $product->price }}</strong> руб.</h6>
													</div>
													<div class="col-xs-4">
														<label class="plus">+</label>
															<input type="number" name="count[]" class="form-control input-sm quantity-product" value="1">
														<label class="minus">-</label>
													</div>
												</div>
											</div>
											<button class="btn btn-danger btn-sm delete-item">
												<i class="fa fa-trash-o"></i>
											</button>
										</div>
									@endforeach
								<div class="col-xs-12">
									<h4>Общая сумма заказа: <strong class="common-price"> {{ $subtotal }}</strong> руб.</h4>
								</div>
								<button type="submit" class="btn btn-success btn-sm col-md-12">Заказать</button>
							</form>
					</div>
				</div>
			</div>
		</div>
	@endif
@endsection