<div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">
<nav class="uk-navbar-container" uk-navbar>
    <div class="uk-navbar-left">
        <ul class="uk-navbar-nav">
            <li class="uk-active"><a href="{{ route('home') }}">Home</a></li>
            @foreach($categories_subcategories as $cat_subcats)
                <li>
                    <a href="{{ route('cats_subcats', ['id' => $cat_subcats->id]) }}">{{ $cat_subcats->name }}</a>
                    @if($cat_subcats->subcategories[0]['name'])
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                @foreach($cat_subcats->subcategories as $subcats)
                                    @if($subcats['name'])
                                        <li><a href="{{ route('cats_subcats', ['id' => $cat_subcats->id, 'subcat_id' => $subcats['id']]) }}">{{ $subcats['name'] }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </li>
            @endforeach 
        </ul>
    </div>

    <div class="uk-navbar-right">
        <ul class="uk-navbar-nav">
            @if (!Auth::user())
                <li class="uk-active"><a href="{{ route('login') }}">Log in</a></li>
                <li class="uk-active"><a href="{{ route('register') }}">Sing up</a></li>
            @else
                <li>
                    <a href="{{ route('cart') }}" uk-icon="icon: cart">
                       <span id="count-product">{{ count(Session::get('products')) }}</span> 
                    </a>
                </li>

                @if(Auth::user()->role == 1)
                    <li>
                        <a href="#">Settings</a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li><a href="{{ route('admin_categories') }}">Categories</a></li>
                                <li><a href="{{ route('admin_subcategories') }}">Subcategories</a></li>
                                <li><a href="{{ route('admin_products') }}">Products</a></li>
                                <li><a href="{{ route('admin_products_out_stock') }}">Out stock</a></li>
                            </ul>
                        </div>
                    </li>
                @endif
                    <li>
                        <form class="uk-navbar-item" id="logout-form" action="{{ route('logout') }}" method="POST">
                            {{ csrf_field() }}
                            <button class="uk-button uk-button-text">Logout</button>
                        </form>
                    </li>
            @endif
        </ul>
    </div>
</nav>
</div>