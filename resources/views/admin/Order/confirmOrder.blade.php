@extends('admin.master')

@section('title')
Order Confirmation
@endsection


@section('sideMenuTitle')
Order Confirmation
@endsection

@section('pageTitle')

@endsection



@section('bodyContent')
<!-- INDIVIDUAL JS FILE -->
<script src="{{ asset('view_js/admin/confirm_order.js') }}"></script>

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
        <div class="col-md-6 centerDiv">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thank you for placing your order.</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->


                <div class="box-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Serial #</th>
                                <th>Product</th>
                                <th>Unit Price({{$settings->currency_symbol}})</th>
                                <th>Qty</th>
                                <th>Sub Total({{$settings->currency_symbol}})</th>
                                <th>Discount</th>
                                <th>Grand Total({{$settings->currency_symbol}})</th>
                            </tr>
                        </thead>
                        <tbody class="show-cart">
                            <?php $i = 1; ?>
                            @foreach($cart["carttArr"] as $val)

                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{$val["product_name"]}}</td>
                                <td>{{$val["unit_price"]}}</td>
                                <td>{{$val["qty"]}}</td>
                                <td>{{$val["unit_price"] * $val["qty"]}}</td>
                                <td>{{($val["discount_type"] == "fixed" ? $settings->currency_symbol : "" )}}{{$val["discount_value"]}}{{($val["discount_type"] == "percentage" ? "%" : "" )}}</td>
                                <td>{{($val["unit_price"] * $val["qty"]) - ($val["discount_amount"]* $val["qty"])}}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">

                        <div class="col-xs-6" style="float: right;">

                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td>{{$settings->currency_symbol}}<span id="subtotal">{{$cart["subTotal"]}}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Discount Amount:</th>
                                        <td>{{$settings->currency_symbol}}<span id="discount">{{$cart["totalDiscount"]}}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Delivery Charge:</th>
                                        <td>{{$settings->currency_symbol}}<span id="charge">{{$cart["delivery_Charge"]}}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Grand Total:</th>
                                        <td>{{$settings->currency_symbol}}<span id="grandtotal">{{$cart["grandTotal"]}}</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->

            </div>
            <!-- /.box -->


        </div>
    </div>

</section>



@endsection