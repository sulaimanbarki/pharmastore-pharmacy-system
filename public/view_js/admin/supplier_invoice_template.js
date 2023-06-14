"use strict";
window.onload = function() {

    $('#tab_logic').on('change', '.productSelect', function(event) {
        var targetId = event.currentTarget.id;
        var index = targetId.split("_")[1];
        var purchasePrice = $(this).find(":selected").data("price");
        console.log(purchasePrice);
        $(`#price_${index}`).val( purchasePrice );
    });

    var i = 1;
    $("#add_row").on("click",function() {
        let b = i - 1;

        //NEW WAY TO ADD NEW ROW
        var newProductRow = `<td>${i + 1}</td>
                <td><select class="form-control productSelect" name="product[]" id="product_${i + 1}" required>
                        <option disabled selected value="">Select Medicine</option>
                        @foreach ($medicines as $medicine)
                        <option value="{{$medicine->id}}" data-price='{{ $medicine->purchasePrice }}'>{{$medicine->name}}</option>
                        @endforeach
                    </select></td>
                <td><input type="number" name='qty[]' placeholder='Enter Qty' class="form-control qty" step="0" min="0" required/></td>
                <td><input type="text" name='price[]' id="price_${i + 1}" placeholder='Enter Unit Price' class="form-control price" readonly /></td>

                <td><select class="form-control discountType" name="discountType[]" id="discountType_${i + 1}">
                        <option value="percentage">Percentage(%)</option>
                        <option value="fixed" selected="">Fixed</option>
                    </select></td>

                <td><input type="number" name='discount[]' placeholder='Enter Discount Price' class="form-control discount" placeholder='0.00'></td>

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
        console.log($('#product').val());
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
            var discountType = $(this).find('#discountType').val();
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