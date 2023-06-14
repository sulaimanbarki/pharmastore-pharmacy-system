@extends('layouts.frontend.app')

@section('content')

<section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('main_home')}}">Home</a></li>
                    <li class="breadcrumb-item active">My Account</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<div class="page-section inner-page-sec-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    @php 
                    $dashboard_tab      ='';
                    $dashboard_menu     ='';
                    $order_tab          ='';
                    $order_menu         ='';
                    $wishlist_tab       ='';
                    $wishlist_menu      ='';
                    $payment_tab        ='';
                    $payment_menu       ='';
                    $address_tab        ='';
                    $address_menu       ='';
                    $account_details_tab='';
                    $account_details_menu='';
                    if(old('firstname') !=''){
                        $account_details_tab= 'active show';
                        $account_details_menu= 'active';
                    }elseif(old('country') !=''){
                        $address_tab        ='active show';
                        $address_menu       ='active';
                    }elseif(session('page')=='wishlist'){
                        $wishlist_tab       ='active show';
                        $wishlist_menu      ='active';
                    }else{
                        $dashboard_tab          ='active show';
                        $dashboard_menu         ='active';
                    }
                    @endphp
                    <div class="col-lg-12">
                        @if(session('message'))
                        <div class="alert alert-{{session('type')}}" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    </div>

                    <!-- My Account Tab Menu Start -->
                    <div class="col-lg-3 col-12">
                        <div class="myaccount-tab-menu nav" role="tablist">
                            <a href="#dashboad" class="{{$dashboard_menu}}" data-toggle="tab"><i
                                    class="fas fa-tachometer-alt"></i>
                                Dashboard</a>
                            <a href="#orders" class="{{$order_menu}}"  data-toggle="tab"><i class="fa fa-cart-arrow-down"></i> Orders</a>
                            <a href="#wishlist" class="{{$wishlist_menu}}"  data-toggle="tab"><i class="fa fa-cart-arrow-down"></i> Wishlist</a>
                            <a href="#payment-method" class="{{$payment_menu}}" data-toggle="tab"><i class="fa fa-credit-card"></i>
                                Payment
                                Method</a>
                            <a href="#address-edit" class="{{$address_menu}}" data-toggle="tab"><i class="fa fa-map-marker"></i>
                                address</a>
                            <a href="#account-info" class="{{$account_details_menu}}" data-toggle="tab"><i class="fa fa-user"></i> Account
                                Details</a>
                            <a href="{{route('logout')}}" onclick="event.preventDefault(); 
                            document.getElementById('my-loggout').submit();
                            ">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            <form action="{{ route('logout')}}" id="my-loggout" method="post"> 
                                @csrf
                            </form>
                            </a>
                        </div>
                    </div>
                    <!-- My Account Tab Menu End -->
                    <!-- My Account Tab Content Start -->

                    <div class="col-lg-9 col-12 mt--30 mt-lg--0">
                        <div class="tab-content" id="myaccountContent">
                            <!-- Single Tab Content Start -->
                            <div class="tab-pane fade {{ $dashboard_tab }}" id="dashboad" role="tabpanel">
                                <div class="myaccount-content">
                                    <h3>Dashboard</h3>
                                    <div class="welcome mb-20">
                                        <p>Hello, <strong>Alex Tuntuni</strong> (If Not <strong>Tuntuni
                                                !</strong><a href="login-register.html" class="logout">
                                                Logout</a>)</p>
                                    </div>
                                    <p class="mb-0">From your account dashboard. you can easily check &amp; view
                                        your
                                        recent orders, manage your shipping and billing addresses and edit your
                                        password and account details.</p>
                                </div>
                            </div>
                            <!-- Single Tab Content End -->
                            <!-- Single Tab Content Start -->
                            <div class="tab-pane fade {{ $order_tab }}" id="orders" role="tabpanel">
                                <div class="myaccount-content">
                                    <h3>Orders</h3>
                                    <div class="myaccount-table table-responsive text-center">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Name</th>
                                                    <th>Date</th>
                                                    <th>Payment Status</th>
                                                    <th>Sub Total</th>
                                                    <th>Discount</th>
                                                    <th>Grand Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orders as $order)
                                                <tr>
                                                    <td>{{$order->order_id}}</td>
                                                    <td>{{$order->customer_name}}</td>
                                                    <td>{{$order->order_date}}</td>
                                                    <td>{{$order->payment_status}}</td>
                                                    <td>{{$order->subtotal}}</td>
                                                    <td>{{$order->total_discount}}</td>
                                                    <td>{{$order->grandtotal}}</td>
                                                </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Tab Content End -->
                            <!-- Single Tab Content Start -->
                            <div class="tab-pane fade {{ $wishlist_tab }}" id="wishlist" role="tabpanel">
                                <div class="myaccount-content">
                                    <h3>Wishlist</h3>
                                    <div class="cart-table table-responsive text-center">
                                        <table class="table">
                                            <!-- Head Row -->
                                            <thead>
                                                <tr>
                                                    <th class="pro-remove"></th>
                                                    <th class="pro-thumbnail">Image</th>
                                                    <th class="pro-title">Product</th>
                                                    <th class="pro-price">Price</th>
                                                    <th class="pro-subtotal">Add To Cart</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Product Row -->
                                                @if($wishlists)
                                               
                                                @foreach($wishlists as $key=>$each_item)
                                                
                                                <tr>
                                                    <td class="pro-remove"><a href="{{route('remove_wishlist',$each_item->id)}}"><i class="far fa-trash-alt"></i></a>
                                                    </td>
                                                    <td class="pro-thumbnail"><a href="{{route('p_details',$each_item->product->id)}}"><img
                                                                src="{{ asset($each_item->product->image) }}" alt="Product"></a></td>
                                                    <td class="pro-title"><a href="{{route('p_details',$each_item->product->id)}}">{{ $each_item->product->name }}</a></td>
                                                    <td class="pro-price"><span>৳&nbsp;{{ $each_item->product->price }}</span></td>
                                                    <td class="pro-subtotal"></td>
                                                </tr>
                                                @endforeach
                                                @else 
                                                <h3 class="text-center">Your cart is empty!</h3>
                                                @endif
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Tab Content End -->
                            <!-- Single Tab Content Start -->
                            <div class="tab-pane fade {{ $payment_tab }}" id="payment-method" role="tabpanel">
                                <div class="myaccount-content">
                                    <h3>Payment Method</h3>
                                    <p class="saved-message">You Can't Saved Your Payment Method yet.</p>
                                </div>
                            </div>
                            <!-- Single Tab Content End -->
                            <!-- Single Tab Content Start -->
                            <div class="tab-pane fade {{ $address_tab }}" id="address-edit" role="tabpanel">
                                <div class="myaccount-content">
                                    <h3>Billing Address</h3>
                                    <div class="account-details-form">
                                        <form action="{{ route('update_address')}}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12 col-12 mb--30">
                                                    <label>Country*</label>
                                                    <select name="country" >
                                                        <option>Bangladesh</option>
                                                        <option>China</option>
                                                        <option>country</option>
                                                        <option>India</option>
                                                        <option>Japan</option>
                                                    </select>
                                                    @if($errors->has('country'))
                                                    <span class="color-ff00">{{$errors->first('country')}}</span>
                                                    @endif
                                                </div>
                                                <div class="col-12  mb--30">
                                                    <input id="address" placeholder="Address" name="address" value="{{ old('address')? old('address') : Auth::user()->address }}" type="text">
                                                    @if($errors->has('address'))
                                                    <span class="color-ff00">{{$errors->first('address')}}</span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6 col-12  mb--30">
                                                    <input id="city" placeholder="city" name="city" value="{{ old('city')? old('city') : Auth::user()->city }}" type="text">
                                                    
                                                    @if($errors->has('city'))
                                                    <span class="color-ff00">{{$errors->first('city')}}</span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6 col-12  mb--30">
                                                    <input id="postcode" placeholder="Zip Code" name="postcode" value="{{ old('postcode')? old('postcode') : Auth::user()->postcode }}" type="text">
                                                    @if($errors->has('postcode'))
                                                    <span class="color-ff00">{{$errors->first('postcode')}}</span>
                                                    @endif
                                                </div>
                                                                                               
                                                
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn--primary">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Tab Content End -->
                            <!-- Single Tab Content Start -->
                            <div class="tab-pane fade {{ $account_details_tab }}" id="account-info" role="tabpanel">
                                <div class="myaccount-content">
                                    <h3>Account Details</h3>
                                    <div class="account-details-form">
                                        <form action="{{ route('update_account_details')}}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6 col-12  mb--30">
                                                    <input id="first-name" placeholder="First Name" name="firstname" value="{{ old('firstname')? old('firstname') : Auth::user()->firstname }}" type="text">
                                                    
                                                    @if($errors->has('firstname'))
                                                    <span class="color-ff00">{{$errors->first('firstname')}}</span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6 col-12  mb--30">
                                                    <input id="last-name" placeholder="Last Name" name="lastname" value="{{ old('lastname')? old('lastname') : Auth::user()->lastname }}" type="text">
                                                    @if($errors->has('lastname'))
                                                    <span class="color-ff00">{{$errors->first('lastname')}}</span>
                                                    @endif
                                                </div>
                                                <div class="col-12  mb--30">
                                                    <input id="display-name" placeholder="Display Name" name="name" value="{{ old('name')? old('name') : Auth::user()->name }}" type="text">
                                                    @if($errors->has('name'))
                                                    <span class="color-ff00">{{$errors->first('name')}}</span>
                                                    @endif
                                                </div>
                                                <div class="col-12  mb--30">
                                                    <input id="email" placeholder="Email Address" name="email" value="{{ old('email')? old('email') : Auth::user()->email }}" type="email">
                                                    @if($errors->has('email'))
                                                    <span class="color-ff00">{{$errors->first('email')}}</span>
                                                    @endif
                                                </div>
                                                <div class="col-12  mb--30">
                                                    <h4>Password change</h4>
                                                </div>
                                                <div class="col-12  mb--30">
                                                    <input id="current-pwd" placeholder="Current Password" name="current_password" type="password">
                                                    @if($errors->has('current_password'))
                                                    <span class="color-ff00">{{$errors->first('current_password')}}</span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6 col-12  mb--30">
                                                    <input id="new-pwd" placeholder="New Password" name="password" type="password">
                                                    @if($errors->has('password'))
                                                    <span class="color-ff00">{{$errors->first('password')}}</span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6 col-12  mb--30">
                                                    <input id="confirm-pwd" placeholder="Confirm Password" name="password_confirmation" type="password">
                                                    @if($errors->has('password_confirmation'))
                                                    <span class="color-ff00">{{$errors->first('password_confirmation')}}</span>
                                                    @endif
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn--primary">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Tab Content End -->
                        </div>
                    </div>
                    <!-- My Account Tab Content End -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection