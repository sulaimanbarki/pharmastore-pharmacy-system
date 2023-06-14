@extends('admin.master')

@section('title')
  Supplier Invoice Details
@endsection 


@section('sideMenuTitle')
  Supplier Invoice
@endsection

@section('pageTitle')
<a href="{{url('supplier/invoicelist')}}"><i class="fa fa-dashboard"></i> Go To Supplier Invoice List</a>
@endsection



@section('bodyContent')

  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i> PharmaStore
          <small class="pull-right">Date:  {{ date('j F, Y', strtotime($invoice->created_at)) }}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong>{{ $settings->name ?? "Company Name" }}</strong><br>
          {{ $settings->address ?? "Company Address" }}<br>
          Phone: {{ $settings->phone ?? "Not Set" }}<br>
          Email: {{ $settings->email ?? "Not Set" }}
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        To
        <address>
          <strong>{{$supplier->name}}</strong><br>
          {{$supplier->address}}<br>
          
          Phone: {{$supplier->phone}}<br>
          Email: {{$supplier->email}}
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Invoice Number</b><br>
        <input type="text" class="form-control" name="invoice_number" value="{{$invoice->invoice_no}}" readonly="">

        <br>
        <b>Payment Type:</b> Cash<br>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Serial #</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Unit Price({{$settings == NULL ? "Currency Not Set" : $settings->currency_symbol ?? "Currency Not Set"}})</th>
            <th>Sub Total({{$settings == NULL ? "Currency Not Set" : $settings->currency_symbol ?? "Currency Not Set"}})</th>
            <th>Discount</th>
            <th>Grand Total({{$settings == NULL ? "Currency Not Set" : $settings->currency_symbol ?? "Currency Not Set"}})</th>
          </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            @foreach($products as $val)
            <?php 
              $product_name = \App\Product::find($val->product_id);
              $name = $product_name->name;
            ?>
          <tr>
             <td>{{ $i++ }}</td>
            <td>{{$name}}</td>
            <td>{{$val->qty_product}}</td>
            <td>{{$val->unit_price}}</td>
            <td>{{$val->subtotal_product}}</td>
            <td>{{ $val->discount_type == "fixed" ? ($settings->currency_symbol) ?? "(Currency Not Set)" : " " }} {{$val->discount_product}}{{$val->discount_type == "fixed" ? "" : "%"}}</td>
            <td>{{$val->grandtotal_product}}</td>
          </tr>
           @endforeach

          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
        <p class="lead">Payment Methods: Cash</p>
        
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <p class="lead">Amount Due - {{date('j F, Y', strtotime($invoice->created_at))}}</p>

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Subtotal:</th>
              <td>({{$settings == NULL ? "Currency Not Set" : $settings->currency_symbol ?? "Currency Not Set"}}) {{$invoice->sum_subtotal}}</td>
            </tr>
            <tr>
              <th>Tax ({{$invoice->tax_percent}}%)</th>
              <td>({{$settings == NULL ? "Currency Not Set" : $settings->currency_symbol ?? "Currency Not Set"}}) {{$invoice->tax_amount}}</td>
            </tr>
           <tr>
              <th>Discount Amount:</th>
              <td>({{$settings == NULL ? "Currency Not Set" : $settings->currency_symbol ?? "Currency Not Set"}}) {{$invoice->sum_discount}}</td>
            </tr>
            <tr>
              <th>Grand Total:</th>
              <td>({{$settings == NULL ? "Currency Not Set" : $settings->currency_symbol ?? "Currency Not Set"}}) {{$invoice->sum_grandtotal}}</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
     <div class="box-footer">
        <button class="btn btn-default" value="print" onclick="print('wrapper')"><i class="fa fa-print"></i> Print</button>
      </div>
  </section>

@endsection 