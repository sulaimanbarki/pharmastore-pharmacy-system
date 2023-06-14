@extends('admin.master')

@section('title')
Order Details
@endsection


@section('sideMenuTitle')
Order Details
@endsection

@section('pageTitle')

@endsection



@section('bodyContent')

<section class="content">
    @if(Session::has('message'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i>
            {{Session::get('message')}}</h4>
    </div>
    @endif

    @if(Session::has('error'))
    <div class="alert alert-danger alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i>
            {{Session::get('error')}}</h4>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row">
        <!-- left column -->
        <div class="col-md-12 centerDiv">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Order# {{$order->order_number}} - Order Status# 
                        <?php
                        if ($order->status == 1) {
                            echo "PENDING";
                        } else if ($order->status == 2) {
                            echo "DELIVERED";
                        }
                        if ($order->status == 3) {
                            echo "REJECTED";
                        }
                        ?>
                    </h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->

                <div class="box-body">
                    <div class="row">
                        {{-- <div class="col-xm-4 col-sm-4 col-md-4 attachment-pushed box-header with-border">
                            <h4 class="attachment-heading"><a>Payment Type</a></h4>
                            <div class="attachment-text">{{strtoupper($order->payment_type)}}</div>
                        </div> --}}
    
                        {{-- <div class="col-xm-4 col-sm-4 col-md-4 attachment-pushed box-header with-border">
                            <h5 class="attachment-heading"><a>Order Status</a></h5>
                            <div class="attachment-text">
                            </div>
                        </div> --}}
                        <div class="col-xm-12 col-sm-12 col-md-12 attachment-pushed box-header with-border">
                            <div class="attachment-text">
                                <img src="{{asset(Auth::user()->image)}}" alt="Company Logo" width="100px" height="100px">
                                <h4>Yashfeen medicose yashfeenmedicose2@gmail.com</h4>
                                <h5>Phone number# 03126787827</h5>
                                <h5>PTCL# 0923 527059</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>


    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Serial #</th>
                        <th>Product</th>
                        <th>Unit Price ({{ $settings ? $settings->currency_symbol ?? "Currency Not Set" : "Currency Not Set" }})</th>
                        <th>Qty</th>
                        <th>Sub Total ({{ $settings ? $settings->currency_symbol ?? "Currency Not Set" : "Currency Not Set" }})</th>
                        <th>Discount</th>
                        <th>Discount Type</th>
                        <th>Grand Total ({{ $settings ? $settings->currency_symbol ?? "Currency Not Set" : "Currency Not Set" }})</th>
                    </tr>
                </thead>
                <tbody class="show-cart">
                    <?php $i = 1; ?>
                    @foreach($products as $val)
                    <?php
                    $product = App\Product::where('id', $val->product_id)->first();
                    ?>
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$val->price}}</td>
                        <td>{{$val->qty}}</td>
                        <td>{{$val->total}}</td>
                        <td>{{$val->discount}}</td>
                        <td>{{$val->discount_type == "fixed" ? ($settings ? $settings->currency_symbol ?? "Currency Not Set" : "Currency Not Set") : "%" }}</td>
                        <td>{{$val->grand_total}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.row -->

    <div class="row">

        <div class="col-xs-6 float-right">

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th class="half-width-pct">Subtotal:</th>
                        <td>({{ $settings ? $settings->currency_symbol ?? "Currency Not Set" : "Currency Not Set" }}) <span id="subtotal">{{ $order->subtotal}}</span></td>
                    </tr>
                    <tr>
                        <th>Discount Amount:</th>
                        <td>({{ $settings ? $settings->currency_symbol ?? "Currency Not Set" : "Currency Not Set" }}) <span id="discount">{{ $order->total_discount}}</span></td>
                    </tr>
                    <tr>
                        <th>Delivery Charge:</th>
                        <td>({{ $settings ? $settings->currency_symbol ?? "Currency Not Set" : "Currency Not Set" }}) <span id="charge">{{ $order->delivery_charge}}</span></td>
                    </tr>
                    <tr>
                        <th>Grand Total:</th>
                        <td>({{ $settings ? $settings->currency_symbol ?? "Currency Not Set" : "Currency Not Set" }}) <span id="grandtotal">{{ $order->grandtotal}}</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</section>

@endsection
