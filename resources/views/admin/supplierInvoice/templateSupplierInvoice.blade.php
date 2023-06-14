@extends('admin.master')

@section('title')
Supplier Invoice Create
@endsection


@section('sideMenuTitle')
Supplier Invoice
@endsection

@section('pageTitle')
<a href="{{url('supplier/invoicelist')}}"><i class="fa fa-dashboard"></i> Go To Supplier Invoice List</a>
@endsection



@section('bodyContent')
<!-- INDIVIDUAL JS FILE -->
<script src="{{ asset('view_js/admin/supplier_invoice_template.js') }}"></script>

<section class="invoice">
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

    <!-- form start -->
    @if (!isset($editData))
    {!! Form::open(['url' => 'supplier/invoiceCreate', 'method' => 'post', 'name' => 'form', 'enctype' => 'multipart/form-data', 'role' => 'form']) !!}
    @endif
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Supplier Invoice 
                <small class="pull-right">Date: {{$invoiceDate}}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From
            <address>
                <strong>{{ $settings == NULL ? "Company Name" : $settings->name ?? "Company Name" }}</strong><br>
                {{ $settings == NULL ? "Company Address" : $settings->address ?? "Company Address" }}<br>
                Phone: {{ $settings == NULL ? "Not Set" : $settings->phone ?? "Not Set" }}<br>
                Email: {{ $settings == NULL ? "Not Set" : $settings->email ?? "Not Set" }}<br>
                {{ $settings == NULL ? "" : $settings->website ?? ""}}<br>

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
            <input type="text" class="form-control" name="invoice_number" value="{{isset($invoice_number) ? $invoice_number:''}}" readonly="">

            <br>
            <b>Payment Type:</b> Cash<br>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- /.box-body -->
    <div class=" row clearfix">
        <div class="col-md-12">
            <table class="table table-bordered table-hover" id="tab_logic">
                <thead>
                    <tr>
                        <th class="text-center"> # </th>
                        <th class="text-center"> Product </th>
                        <th class="text-center"> Qty </th>
                        <th class="text-center"> Price ({{ $settings == NULL ? "Currency Not Set" : $settings->currency_symbol ?? "Currency Not Set" }})</th>
                        <th class="text-center"> Discount Type</th>
                        <th class="text-center"> Discount </th>
                        <th class="text-center"> Total </th>
                    </tr>
                </thead>
                <tbody>
                    <tr id='addr0'>
                        <td>1</td>
                        <td><select class="form-control productSelect" name="product[]" id="product_1" required>
                                <option disabled selected value="">Select Medicine</option>
                                @foreach ($medicines as $medicine)
                                <option value="{{$medicine->id}}" data-price="{{ $medicine->purchasePrice }}">{{$medicine->name}}</option>
                                @endforeach
                            </select></td>
                        <td><input type="number" name='qty[]' placeholder='Enter Qty' class="form-control qty" step="0" min="0" required/></td>
                        <td><input type="number" name='price[]' placeholder='Enter Unit Price' class="form-control price" step="0.01" id="price_1" readonly/></td>

                        <td><select class="form-control" name="discountType[]" id="discountType">
                                <option value="percentage">Percentage(%)</option>
                                <option value="fixed" selected="">Fixed</option>
                            </select></td>

                        <td><input type="number" name='discount[]' placeholder='Enter Discount Price' class="form-control discount" placeholder='0.00'></td>

                        <td><input type="number" name='grandtotal[]' placeholder='0.00' class="form-control grandtotal" readonly /></td>
                        <td><input type="hidden" name='total[]' placeholder='0.00' class="form-control total" readonly /></td>
                    </tr>
                    <tr id='addr1'></tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="clearfix">
        <div class="col-md-12">
            <button id="add_row" class="btn bg-green pull-left"> + Add More</button>
            <button id="delete_row" class="btn bg-red pull-right"> <i class="fa fa-trash"></i> Delete</button>

        </div>
    </div>
    <div class="row clearfix margin-top-20">
        <div class="pull-right col-md-6">
            <table class="table table-bordered table-hover" id="tab_logic_total">
                <tbody>
                    <tr>
                        <th class="text-center">Sub Total({{$settings == NULL ? "Currency Not Set" : $settings->currency_symbol ?? "Currency Not Set"}})</th>
                        <td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly /></td>
                    </tr>
                    <tr>
                        <th class="text-center">Discount({{$settings == NULL ? "Currency Not Set" : $settings->currency_symbol ?? "Currency Not Set"}})</th>
                        <td class="text-center"><input type="number" name='discount_amount' placeholder='0.00' class="form-control" id="discount_amount" readonly /></td>
                    </tr>
                    <tr>
                        <th class="text-center">Tax</th>
                        <td class="text-center">
                            <div class="input-group mb-2 mb-sm-0">
                                <input type="number" class="form-control" id="tax" placeholder="0" name="taxPercent" value="0">
                                <div class="input-group-addon">%</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center">Tax Amount({{$settings == NULL ? "Currency Not Set" : $settings->currency_symbol ?? "Currency Not Set"}})</th>
                        <td class="text-center"><input type="number" name='tax_amount' id="tax_amount" placeholder='0.00' class="form-control" readonly /></td>
                    </tr>
                    <tr>
                        <th class="text-center">Grand Total({{$settings == NULL ? "Currency Not Set" : $settings->currency_symbol ?? "Currency Not Set"}})</th>
                        <td class="text-center"><input type="number" name='total_amount' id="total_amount" placeholder='0.00' class="form-control" readonly /></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="box-footer">
        <button type="submit" class="btn btn-primary pull-right" value="submit">Submit Invoice</button>
        <input type="hidden" class="form-control" name="supplier" value="{{$supplier->id}}">

    </div>
    {!! Form::close() !!}
</section>

@endsection