@extends('layouts.frontend.app')

@section('content')

<!-- INDIVIDUAL CSS -->
<link rel="stylesheet" href="{{ asset('view_css/frontend/cart.css') }}">

<section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('main_home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Cart</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<!-- Cart Page Start -->
<main class="cart-page-main-block inner-page-sec-padding-bottom">
    <div class="cart_area cart-area-padding  ">
        <div class="container">
            <div class="page-section-title">
                <h1>Shopping Cart</h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="#" class="">
                        <!-- Cart Table -->
                        <div class="cart-table table-responsive mb--40">
                            <table class="table" id="cart_table"></table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="cart-section-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12 mb--30 mb-lg--0">
                </div>

                <!-- Cart Summary -->
                <div class="col-lg-6 col-12 d-flex" id="cart_summery">

                </div>
            </div>
        </div>
    </div>
</main>
<!-- Cart Page End -->
@endsection
@section('scripts')
<script>
    "use strict";
    var cart_data = @json($cart_data);
    generateCartPageHtml();
</script>
@stop