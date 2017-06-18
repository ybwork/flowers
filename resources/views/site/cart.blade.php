@extends('layouts.app')

@section('content')

	@if(count($products) != 0)
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="panel panel-info">
						@foreach($products as $key => $product)
							<form id="delete-item" action="{{ route('product_delete_from_cart') }}" method="POST">
								<div class="panel-body">
									<div class="row">
										<div class="col-xs-2"><img class="img-responsive" src="{{ asset($product->image) }}">
										</div>
										<div class="col-xs-4">
											<h4 class="product-name"><strong>{{ $product->name }}</strong></h4><h4><small>{{ $product->description }}</small></h4>
										</div>
										<div class="col-xs-6">
											<div class="col-xs-6 text-right">
												<h6><strong>${{ $product->price }}</strong></h6>
											</div>
											<div class="col-xs-4">
												<input type="number" class="form-control input-sm" value="1">
											</div>

											<div class="col-xs-2">
												<input type="hidden" name="_method" value="DELETE">
												<input id="product_id" type="hidden" name="product_id" value="{{ $product->id }}">
												<input type="hidden" name="_token" value="{{ csrf_token() }}">
												<button type="submit" class="btn btn-danger btn-sm">
													<i class="fa fa-trash-o"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
							</form>
						@endforeach
					</div>
				</div>
				
				<div class="col-xs-12">
					<h4><strong>Subtotal ${{ $subtotal }}</strong></h4>
					<button type="submit" class="btn btn-success btn-sm col-md-12">
						To order
					</button>
				</div>
			</div>
		</div>
	@endif
@endsection