<div class="site-header d-none d-lg-block">
    <div class="header-middle pt--10 pb--10">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 ">
                    <a href="{{route('main_home')}}" class="site-brand">
                        <h4>Pharmastore</h4>
                    </a>
                </div>
                <div class="col-lg-3">
                    <div class="header-phone ">
                        <div class="icon">
                            <i class="fas fa-headphones-alt"></i>
                        </div>
                        <div class="text">
                            <p>Free Support 24/7</p>
                            <p class="font-weight-bold number">{{ isset($settings) ? $settings->phone ?? "" : "" }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="main-navigation flex-lg-right">
                        <ul class="main-menu menu-right ">
                            <li class="menu-item">
                                <a href="{{route('main_home')}}">Home </a>                                
                            </li>                           
                            <li class="menu-item">
                                <a href="{{ route('about')}}">About Us</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('contact')}}">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom pb--10">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <nav class="category-nav">
                        <div>
                            <a href="javascript:void(0)" class="category-trigger"><i
                                    class="fa fa-bars"></i>Browse
                                categories</a>
                            <ul class="category-menu">
                                @foreach($categories as $each_category)
                                <li class="cat-item">
                                    <a href="{{route('category_product',$each_category->id)}}">{{$each_category->name}}</a>
                                </li>
                                @endforeach
                                
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="col-lg-5">
                    <div class="header-search-block">
                        <form action="{{ route('search')}}" method="get">
                            
                        <input type="text" name="q" placeholder="Search entire store here">
                        <button type="submit">Search</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="main-navigation flex-lg-right">
                        <div class="cart-widget">
                            <div class="cart-block">
                                @if(Route::currentRouteName()=='cart' || Route::currentRouteName()=='checkout')
                                <div class="cart-total">
                                    <span class="text-number">
                                        0
                                    </span>
                                    <span class="text-item">
                                        Shopping Cart
                                    </span>
                                    <span class="price">
                                        <span class="cart_total">({{ isset($settings) ? $settings->currency_symbol ?? "" : "" }}) 0.00</span>
                                    </span>
                                </div>
                                @else
                                    <div class="cart-total">
                                        <span class="text-number">
                                            0
                                        </span>
                                        <span class="text-item">
                                            Shopping Cart
                                        </span>
                                        <span class="price">
                                            <span class="cart_total">({{ isset($settings) ? $settings->currency_symbol ?? "" : "" }}) 0.00</span>
                                            <i class="fas fa-chevron-down"></i>
                                        </span>
                                    </div>
                                    <div class="cart-dropdown-block shopping-cart">
                                    
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>