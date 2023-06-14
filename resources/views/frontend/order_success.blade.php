@extends('layouts.frontend.app')

@section('content')
<section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Order Complete</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- order complete Page Start -->
<section class="order-complete inner-page-sec-padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="order-complete-message text-center">
                    <h1>Thank you !</h1>
                    <p>Your order has been received.</p>
                </div>
                <ul class="order-details-list">
                    <li>Order Number: <strong>{{$order->order_number}}</strong></li>
                    <li>Date: <strong>{{ date('Y-m-d')}}</strong></li>
                    <li>Total: <strong>{{ isset($settings) ? $settings->currency_symbol ?? "Currency Not Set " : "Currency Not Set " }} {{$order->grandtotal}}</strong></li>
                    <li>Payment Method: <strong>{{$order->payment->type}}</strong></li>
                </ul>
                <p>Pay with cash upon delivery.</p>
                <h3 class="order-table-title">Order Details</h3>
                <div class="table-responsive">
                    <table class="table order-details-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order_products as $product)
                            <tr>
                                <td><a href="single-product.html">{{$product->product->name}}</a> <strong>× {{$product->qty}}</strong></td>
                                <td><span>{{$product->product->sellingPrice * $product->qty}}</span></td>
                            </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Subtotal:</th>
                                <td><span>{{ isset($settings) ? $settings->currency_symbol ?? "Currency Not Set " : "Currency Not Set " }} {{$order->subtotal}}</span></td>
                            </tr>
                            <tr>
                                <th>Discount:</th>
                                <td><span>{{ isset($settings) ? $settings->currency_symbol ?? "Currency Not Set " : "Currency Not Set " }} {{$order->total_discount}}</span></td>
                            </tr>
                            <tr>
                                <th>Delivery Charge:</th>
                                <td><span>{{ isset($settings) ? $settings->currency_symbol ?? "Currency Not Set " : "Currency Not Set " }} {{$order->delivery_charge}}</span></td>
                            </tr>
                            <tr>
                                <th>Payment Method:</th>
                                <td>{{$order->payment->type}}</td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td><span>{{ isset($settings) ? $settings->currency_symbol ?? "Currency Not Set " : "Currency Not Set " }} {{$order->grandtotal}}</span></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- order complete Page End -->
@endsection