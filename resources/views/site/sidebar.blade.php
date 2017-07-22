<div class="container">
	<div class="header clearfix">
		<nav>
			<ul class="nav nav-pills pull-right">
                @if (Auth::guest())
                    <li class="account-menu"><a href="{{ route('login') }}">Login</a></li>
                    <li class="account-menu"><a href="{{ route('register') }}">Register</a></li>
                @elseif (Auth::user()->id == 1)
                    <li class="account-menu"><a href="{{ route('admin_categories') }}">Categories</a></li>
                    <li class="account-menu"><a href="{{ route('admin_subcategories') }}">Subcategories</a></li>
                    <li class="account-menu"><a href="{{ route('admin_products') }}">Products</a></li>
                    <li class="account-menu"><a href="{{ route('admin_products_out_stock') }}">Products out stock</a></li>
                    <li class="cart">
                        <a href="{{ route('cart') }}">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            <span id="count-product">{{ count(Session::get('products')) }}</span>
                        </a>
                    </li>
                    <li class="dropdown account-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>                   
                    @foreach($categories_subcategories as $cat_subcats)
                        <li class="grid"><a href="{{ route('cats_subcats', ['id' => $cat_subcats->id]) }}">{{ $cat_subcats->name }}</a>
                        @if($cat_subcats->subcategories[0]['name'])
                            <div class="mepanel">
                                <div class="row">
                                    <div class="col1 me-one">
                                        <ul>
                                        @foreach($cat_subcats->subcategories as $subcats)
                                            @if($subcats['name'])
                                                <li><a href="{{ route('cats_subcats', ['id' => $cat_subcats->id, 'subcat_id' => $subcats['id']]) }}">{{ $subcats['name'] }}</a></li>
                                            @endif
                                        @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                        </li>
                    @endforeach
                @else
	                <li class="cart">
						<a href="{{ route('cart') }}">
							<i class="fa fa-shopping-cart" aria-hidden="true"></i>
							<span id="count-product">{{ count(Session::get('products')) }}</span>
						</a>
					</li>
                    <li class="dropdown account-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
			</ul>

		</nav>
		<h3 class="text-muted"><a class="home" href="{{ route('home') }}">Home</a></h3>
	</div>
</div>
