<div class="container">
	<div class="header clearfix">
		<nav>
			<ul class="nav nav-pills pull-right">
                <li class="account-menu"><a class="home" href="{{ route('home') }}">Главная</a></li>
            @if (Auth::user())
                <!-- Admin navig -->
                @if (Auth::user()->role == 1):
                    <li class="account-menu"><a href="{{ route('admin_categories') }}">Категории</a></li>
                    <li class="account-menu"><a href="{{ route('admin_subcategories') }}">Подкатегории</a></li>
                    <li class="account-menu"><a href="{{ route('admin_products') }}">Продукты</a></li>
                    <li class="account-menu"><a href="{{ route('admin_products_out_stock') }}">Нет на складе</a></li>
                @endif

                <!-- Site navig -->
                @foreach($categories_subcategories as $cat_subcats)

                    <li class="account-menu"><a href="{{ route('cats_subcats', ['id' => $cat_subcats->id]) }}">{{ $cat_subcats->name }}</a>
                    @if($cat_subcats->subcategories[0]['name'])
                        <ul class="nav nav-pills pull-right">
                            @foreach($cat_subcats->subcategories as $subcats)
                                @if($subcats['name'])
                                    <li class="account-menu"><a href="{{ route('cats_subcats', ['id' => $cat_subcats->id, 'subcat_id' => $subcats['id']]) }}">{{ $subcats['name'] }}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                    </li>
                @endforeach
            @endif

                @if (Auth::guest())
                    <li class="account-menu"><a href="{{ route('login') }}">Вход</a></li>
                    <li class="account-menu"><a href="{{ route('register') }}">Регистрация</a></li>
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
                                    Выйти
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
	</div>
</div>
