@extends('layouts.frontend.app')

@section('content')
<link rel="stylesheet" href="{{ asset('view_css/frontend/checkout.css') }}">
<section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('main_home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Checkout</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Cart Page Start -->
<main id="content" class="page-section inner-page-sec-padding-bottom space-db--20">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Checkout Form s-->
                <div class="checkout-form">
                    <div class="row row-40">
                        <div class="col-12">
                            @guest
                           
                            
                            <div class="checkout-slidedown-box" id="quick-login">
                                <form action="{{ route('customer.signin.submit')}}" method="POST">
                                    @csrf
                                    <div class="quick-login-form">
                                        <p>If you have shopped with us before, please enter your details in the
                                            boxes below. If you are a new
                                            customer
                                            please
                                            proceed to the Billing & Shipping section.</p>
                                        <div class="form-group">
                                            <label for="quick-user">Email *</label>
                                            <input type="email" placeholder="" name="email" id="quick-user">
                                        </div>
                                        <div class="form-group">
                                            <label for="quick-pass">Password *</label>
                                            <input type="password" name="password" placeholder="" id="quick-pass">
                                        </div>
                                        <div class="form-group">
                                            <div class="d-flex align-items-center flex-wrap">
                                                {{-- <a href="#" class="btn btn-outlined   mr-3">Login</a> --}}
                                                <input type="hidden" name="checkout_login" value="checkout">
                                                <button type="submit" class="btn btn-outlined   mr-3">Login</button>
                                                <div class="d-inline-flex align-items-center">
                                                    <input type="checkbox" id="accept_terms" class="mb-0 mr-1">
                                                    <label for="accept_terms" class="mb-0">I’ve read and accept
                                                        the terms &amp; conditions</label>
                                                </div>
                                            </div>
                                            <p><a href="javascript:" class="pass-lost mt-3">Lost your
                                                    password?</a></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endguest

                        </div>
                        <form action="{{ route('orderprocess')}}" method="post" id="payment-form">
                            @csrf
                            <div class="row">
                                @if ($errors->has('isagree'))
                                <div class="col-12">
                                    <div class="alert alert-danger">
                                        <div class="alert alert-danger" role="alert">
                                            {{$errors->first('isagree')}}
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-7 mb--20">
                                <!-- Billing Address -->
                                <div id="billing-form" class="mb-40">
                                    <h4 class="checkout-title">Checkout</h4>
                                    <div class="row">
                                        <div class="col-md-6 col-12 mb--20">
                                            <label>First Name* </label>
                                            <input type="text" name="firstname" value="{{ old('firstname') ? old('firstname'): (Auth::check()? Auth::user()->firstname :'') }}" placeholder="First Name">
                                            @if($errors->has('firstname'))
                                            <span class="color-ff00">{{$errors->first('firstname')}}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6 col-12 mb--20">
                                            <label>Last Name*</label>
                                            <input type="text" name="lastname" value="{{ old('lastname') ? old('lastname'): (Auth::check()? Auth::user()->lastname :'') }}" placeholder="Last Name">
                                            @if($errors->has('lastname'))
                                            <span class="color-ff00">{{$errors->first('lastname')}}</span>
                                            @endif
                                        </div>
                                        {{-- <div class="col-12 mb--20">
                                            <label>Company Name (Optional)</label>
                                            <input type="text" placeholder="Company Name">
                                        </div> --}}
                                        <div class="col-12 col-12 mb--20">
                                            <label>Country*</label>
                                            <select class="nice-select" name="country" >
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
                                        <div class="col-md-6 col-12 mb--20">
                                            <label>Email Address*</label>
                                            <input type="email" name="email" value="{{ old('email') ? old('email'): (Auth::check()? Auth::user()->email :'') }}" placeholder="Email Address">
                                            @if($errors->has('email'))
                                            <span class="color-ff00">{{$errors->first('email')}}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6 col-12 mb--20">
                                            <label>Phone no*</label>
                                            <input type="text" name="phone" value="{{ old('phone') ? old('phone'): (Auth::check()? Auth::user()->phone :'') }}" placeholder="Phone number">
                                            @if($errors->has('phone'))
                                            <span class="color-ff00">{{$errors->first('phone')}}</span>
                                            @endif
                                        </div>
                                        <div class="col-12 mb--20">
                                            <label>Address*</label>
                                            <input type="text" name="address" value="{{ old('address') ? old('address'): (Auth::check()? Auth::user()->address :'') }}"  placeholder="Address">
                                            {{-- <input type="text" placeholder="Address line 2"> --}}
                                            @if($errors->has('address'))
                                            <span class="color-ff00">{{$errors->first('address')}}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6 col-12 mb--20">
                                            <label>Town/City*</label>
                                            <input type="text" name="city" value="{{ old('city') ? old('city'): (Auth::check()? Auth::user()->city :'') }}" placeholder="Town/City">
                                            @if($errors->has('city'))
                                            <span class="color-ff00">{{$errors->first('city')}}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6 col-12 mb--20">
                                            <label>Zip Code*</label>
                                            <input type="text" name="postcode" value="{{ old('postcode') ? old('postcode'): (Auth::check()? Auth::user()->postcode :'') }}" placeholder="Zip Code">
                                            @if($errors->has('postcode'))
                                            <span class="color-ff00">{{$errors->first('postcode')}}</span>
                                            @endif
                                        </div>
                                        {{-- <div class="col-md-6 col-12 mb--20">
                                            <label>Zip Code*</label>
                                            <input type="text" placeholder="Zip Code">
                                        </div> --}}
                                        
                                        {{-- <div class="col-12 mb--20 ">
                                            <div class="block-border check-bx-wrapper">
                                                <div class="check-box">
                                                    <input type="checkbox" id="create_account" value="create_account">
                                                    <label for="create_account">Create an Acount?</label>
                                                </div>
                                                <div class="check-box">
                                                    <input type="checkbox" id="shiping_address" data-shipping>
                                                    <label for="shiping_address">Ship to Different Address</label>
                                                </div>
                                            </div>
                                        </div> --}}
                                        
                                    </div>
                                </div>
                                <!-- Shipping Address -->
                                <div id="shipping-form" class="mb--40">
                                    <h4 class="checkout-title">Shipping Address</h4>
                                    <div class="row">
                                        <div class="col-md-6 col-12 mb--20">
                                            <label>First Name*</label>
                                            <input type="text" placeholder="First Name">
                                        </div>
                                        <div class="col-md-6 col-12 mb--20">
                                            <label>Last Name*</label>
                                            <input type="text" placeholder="Last Name">
                                        </div>
                                        <div class="col-md-6 col-12 mb--20">
                                            <label>Email Address*</label>
                                            <input type="email" placeholder="Email Address">
                                        </div>
                                        <div class="col-md-6 col-12 mb--20">
                                            <label>Phone no*</label>
                                            <input type="text" placeholder="Phone number">
                                        </div>
                                        <div class="col-12 mb--20">
                                            <label>Company Name</label>
                                            <input type="text" placeholder="Company Name">
                                        </div>
                                        <div class="col-12 mb--20">
                                            <label>Address*</label>
                                            <input type="text" placeholder="Address line 1">
                                            <input type="text" placeholder="Address line 2">
                                        </div>
                                        <div class="col-md-6 col-12 mb--20">
                                            <label>Country*</label>
                                            <select class="nice-select">
                                                <option>Bangladesh</option>
                                                <option>China</option>
                                                <option>country</option>
                                                <option>India</option>
                                                <option>Japan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 col-12 mb--20">
                                            <label>Town/City*</label>
                                            <input type="text" placeholder="Town/City">
                                        </div>
                                        <div class="col-md-6 col-12 mb--20">
                                            <label>State*</label>
                                            <input type="text" placeholder="State">
                                        </div>
                                        <div class="col-md-6 col-12 mb--20">
                                            <label>Zip Code*</label>
                                            <input type="text" placeholder="Zip Code">
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="order-note-block mt--30">
                                    <label for="order-note">Order notes</label>
                                    <textarea id="order-note" name="order_notes" cols="30" rows="10" class="order-note"
                                        placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                </div> --}}
                            </div>
                            <div class="col-lg-5">
                                <div class="row">
                                    <!-- Cart Total -->
                                    <div class="col-12">
                                        <div class="checkout-cart-total">
                                            <h2 class="checkout-title">YOUR ORDER</h2>
                                            @if(session('cart_data'))
                                            <h4>Product <span>Total</span></h4>
                                            <ul>
                                                @php
                                                    $subtotal=0;
                                                    $delivery_fee=60;
                                                @endphp

                                                @foreach(session('cart_data') as $each_product)
                                                @php $subtotal= $subtotal + ($each_product['price'] * $each_product['quantity']) @endphp
                                                <li><span class="left">{{$each_product['pname'].' X '.$each_product['quantity']}} </span> <span
                                                        class="right">{{ isset($settings) ? $settings->currency_symbol ?? "Currency Not Set " : "Currency Not Set " }} {{ number_format($each_product['price'] * $each_product['quantity'],2)}}</span></li>
                                                
                                                @endforeach
                                            </ul>
                                            <p>Sub Total <span>{{ isset($settings) ? $settings->currency_symbol ?? "Currency Not Set " : "Currency Not Set " }} {{number_format($subtotal,2)}}</span></p>
                                            <p>Shipping Fee <span>{{ isset($settings) ? $settings->currency_symbol ?? "Currency Not Set " : "Currency Not Set " }} {{number_format($delivery_charge,2)}}</span></p>
                                            <h4>Grand Total <span>{{ isset($settings) ? $settings->currency_symbol ?? "Currency Not Set " : "Currency Not Set " }} {{ number_format(($cart_data['grandtotal'] + $delivery_charge),2)}}</span></h4>
                                            @else 
                                            <h4>Your cart is empty!</h4>
                                            @endif
                                            {{-- <div class="method-notice mt--25">
                                                <article>
                                                    <h3 class="d-none sr-only">blog-article</h3>
                                                    Sorry, it seems that there are no available payment methods for
                                                    your state. 
                                                </article>


                                            </div> --}}
                                            <p>
                                            <div class="method-notice mt--25">
                                                {{-- <div class="col-md-12 col-12 mb--20">
                                                    <label>Phone no*</label>
                                                    <input type="text" placeholder="Phone number">
                                                </div> --}}
                                                @foreach($payment_methods as $each_method)
                                                @php
                                                $checked='';
                                                if($loop->index==0){$checked='checked';}   
                                                @endphp
                                                <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" {{ $checked }} id="payment_{{$each_method->id}}" name="payment_method" data-payment="{{$each_method->id}}" value="{{$each_method->id}}" class="custom-control-input payment_btn">
                                                    <label class="custom-control-label form-control" for="payment_{{$each_method->id}}">{{$each_method->type}}</label>
                                                </div>
                                                @endforeach                                                  

                                            </div>
                                            <div class="stripe-payment-box">
                                               
                                                    <div class="form-row">
                                                        <div class="col-md-12 col-12">
                                                            <label>Name on Card</label>
                                                            <input type="text" name="card_customer_name" placeholder="Name" >
                                                        </div>
                                                      <label for="card-element">
                                                        Credit or debit card
                                                      </label>
                                                      <div id="card-element">
                                                        <!-- A Stripe Element will be inserted here. -->
                                                      </div>
                                                  
                                                      <!-- Used to display form errors. -->
                                                      <div id="card-errors" role="alert"></div>
                                                    </div>                                                  
                                           </div>
                                            

                                        </p>
                                            <div class="term-block">
                                                <input type="checkbox" checked id="accept_terms2" name="isagree" value="1">
                                                <label for="accept_terms2">I’ve read and accept the terms &
                                                    conditions</label>
                                            </div>
                                            <button type="" class="place-order w-100">Place order</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Cart Page Start -->

<script src="https://js.stripe.com/v3/"></script>
<script src="{{ asset('view_js/frontend/checkout.js') }}"></script>
@endsection

