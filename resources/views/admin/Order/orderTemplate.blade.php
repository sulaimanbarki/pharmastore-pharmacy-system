@extends('admin.master')

@section('title')
Medicine Order
@endsection


@section('sideMenuTitle')
Medicine Order
@endsection

@section('pageTitle') @endsection



@section('bodyContent')
<!-- INDIVIDUAL JS FILE -->
<script src="{{ asset('view_js/admin/order_template.js') }}"></script>

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
    {!! Form::open(['url' => 'order/save', 'method' => 'post', 'name' => 'form', 'enctype' => 'multipart/form-data', 'role' => 'form']) !!}
    @endif

    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            <address>
                <strong>{{$settings ? $settings->name ?? "Company Name" : "Company Name" }}</strong><br>
                {{$settings ? $settings->address ?? "Address" : "Address" }}<br>
                {{$settings ? "Phone:" . $settings->phone ?? "Phone Number" : "Phone Number" }}<br>
                {{$settings ? "Email: " . $settings->email ?? "Email Address" : "Email Address" }}<br>
                {{$settings ? $settings->website ?? "Website Address" : "Website Address" }}<br>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col"></div>
        <div class="col-sm-4 invoice-col">
            <b>Order Number</b><br>
            <input type="text" class="form-control" name="order_number" value="{{isset($order_number) ? $order_number:''}}" readonly="">

            <br>
            <b>Payment Type:</b> Cash<br>
            <input type="hidden" name='payment' class="form-control" value="Cash On Delivery"/>
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
                        <th class="text-center"> Price ({{$settings ? $settings->currency_symbol ?? "Currency Not Set" : "Currency Not Set" }})</th>
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
                                <option value="{{$medicine->id}}" data-price="{{ $medicine->sellingPrice }}">{{$medicine->name}}</option>
                                @endforeach
                            </select></td>
                        <td><input type="number" name='qty[]' placeholder='Enter Qty' class="form-control qty" step="0" min="0" required/></td>
                        <td><input type="text" name='price[]' id="price_1" placeholder='Enter Unit Price' class="form-control price" readonly/></td>

                        <td><select class="form-control discountType" name="discountType[]" id="discountType_1">
                                <option value="percentage">Percentage(%)</option>
                                <option value="fixed" selected="">Fixed</option>
                            </select></td>

                        <td><input type="number" name='discount[]' max="10" placeholder='Enter Discount Price' class="form-control discount" placeholder='0.00'></td>

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
            <button id="add_row" type="button" class="btn bg-green pull-left"> + Add More</button>
            <button id="delete_row" class="btn bg-red pull-right"> <i class="fa fa-trash"></i> Delete</button>

        </div>
    </div>
    <div class="row clearfix margin-top-20">
        <div class="pull-right col-md-6">
            <table class="table table-bordered table-hover" id="tab_logic_total">
                <tbody>
                    <tr>
                        <th class="text-center">Sub Total({{ $settings ? $settings->currency_symbol ?? "Currency" : "Currency" }})</th>
                        <td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly /></td>
                    </tr>
                    <tr>
                        <th class="text-center">Discount({{ $settings ? $settings->currency_symbol ?? "Currency" : "Currency" }})</th>
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
                        <th class="text-center">Tax Amount({{ $settings ? $settings->currency_symbol ?? "Currency" : "Currency" }})</th>
                        <td class="text-center"><input type="number" name='tax_amount' id="tax_amount" placeholder='0.00' class="form-control" readonly /></td>
                    </tr>
                    <tr>
                        <th class="text-center">Grand Total({{ $settings ? $settings->currency_symbol ?? "Currency" : "Currency" }})</th>
                        <td class="text-center"><input type="number" name='total_amount' id="total_amount" placeholder='0.00' class="form-control" readonly /></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="box-footer">
        <button type="submit" class="btn btn-primary pull-right" value="submit">Submit Order</button>
    </div>
    {!! Form::close() !!}

    
</section>

<script>
    "use strict";
window.onload = function() {

    $('#tab_logic').on('change', '.productSelect', function(event) {
        var targetId = event.currentTarget.id;
        var index = targetId.split("_")[1];
        var sellingPrice = $(this).find(":selected").data("price");
        console.log(sellingPrice);
        $(`#price_${index}`).val($(this).find(":selected").data("price"));
    });


    var i = 1;
    $("#add_row").on("click",function() {
        // b = i - 1;
        var newProductRow = `<td>${i + 1}</td>
                <td><select class="form-control productSelect" name="product[]" id="product_${i + 1}" required>
                        <option disabled selected value="">Select Medicine</option>
                        @foreach ($medicines as $medicine)
                        <option value="{{$medicine->id}}" data-price='{{ $medicine->sellingPrice }}'>{{$medicine->name}}</option>
                        @endforeach
                    </select></td>
                <td><input type="number" name='qty[]' placeholder='Enter Qty' class="form-control qty" step="0" min="0" required/></td>
                <td><input type="text" name='price[]' id="price_${i + 1}" placeholder='Enter Unit Price' class="form-control price" readonly /></td>

                <td><select class="form-control discountType" name="discountType[]" id="discountType_${i + 1}">
                        <option value="percentage">Percentage(%)</option>
                        <option value="fixed" selected="">Fixed</option>
                    </select></td>

                <td><input type="number" name='discount[]' max="10" placeholder='Enter Discount Price' class="form-control discount" placeholder='0.00'></td>

                <td><input type="number" name='grandtotal[]' placeholder='0.00' class="form-control grandtotal" readonly /></td>
                <td><input type="hidden" name='total[]' placeholder='0.00' class="form-control total" readonly /></td>`;
        $('#addr' + i).html(newProductRow);
        $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
        i++;
        return false;
    });
    
    $("#delete_row").on("click",function() {
        if (i > 1) {
            $("#addr" + (i - 1)).html('');
            i--;
        }
        calc();
        return false;
    });

    $('#tab_logic tbody').on('keyup change', function() {
        calc();
    });
    $('#tax').on('keyup change', function() {
        calc_total();
    });

}

function calc() {
    $('#tab_logic tbody tr').each(function(i, element) {
        var html = $(this).html();
        if (html != '') {
            var qty = $(this).find('.qty').val();
            var price = $(this).find('.price').val();
            var discount = $(this).find('.discount').val();
            var discountType = $(this).find('.discountType').val();
            console.log(discountType);
            var discountCalc = 0;
            if (discountType == "fixed") {
                discountCalc = (qty * price) - discount;
            } else {
                discountCalc = (qty * price) - ((discount / 100) * (qty * price));
            }
            $(this).find('.total').val((qty * price));
            $(this).find('.grandtotal').val(discountCalc);
            $(this).find('.discount').val(discount);

            calc_total();
        }
    });
}

function calc_total() {
    let total = 0;
    let grandTotal = 0;
    let discount = 0;
    $('.total').each(function() {
        total += parseFloat($(this).val());
    });

    $('#sub_total').val(total.toFixed(2));

    $('.grandtotal').each(function() {
        grandTotal += parseFloat($(this).val());
    });

    discount = total - grandTotal;
    $('#discount_amount').val(discount.toFixed(2));

    let tax_sum = total / 100 * $('#tax').val();
    $('#tax_amount').val(tax_sum.toFixed(2));
    $('#total_amount').val((grandTotal + tax_sum).toFixed(2));
}
</script>

@endsection