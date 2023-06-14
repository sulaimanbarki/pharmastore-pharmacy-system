"use strict";
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    generateCartHtml();
     generateCartPageHtml();
     cartSummery();
});


$('.add-to-cart').on("click", function() {
    console.log('adding to cart');
    var index_id = $(this).attr('index-id');

    if (index_id == 'single_product') {
        // add to cart from product details page
        var product = productArray;
    } else {
        // add to cart from home page
        var product = productArray[index_id];
    }

    var data_id = $(this).attr('data-id');


    var isExist = false;
    if (cart.length > 0) {
        for (var i = 0; i < cart.length; i++) {
            if (product.id == cart[i].pid) {
                isExist = true;
                break;
            }
        }
    }

    if (isExist == true) {
        cart[i].quantity = Number(cart[i].quantity) + 1;
    } else {
        var singledata = {
            "pid": product.id,
            "pname": product.name,
            "quantity": 1,
            "price": product.sellingPrice,
            'image': product.image
        };
        cart.push(singledata);
    }

    generateCartHtml();
    $('.notification-area').html('<p>Item added successfully!</p>');
    $('.notification-area').fadeIn('fast').delay(1000).fadeOut(1000);
    //console.log(cart);
});


function generateCartHtml() {
    var carthtml = '';
    var item_qty = 0;
    var cart_total = 0;
    if (cart.length > 0) {
        carthtml += '<div class=" single-cart-block ">';
        for (let x = 0; x < cart.length; x++) {

            var cart_data = cart[x];
            item_qty = item_qty + parseInt(cart_data.quantity);

            cart_total = cart_total + (parseInt(cart_data.quantity) * parseFloat(cart_data.price));

            var imglink = '{{ asset("")}}' + cart_data.image;
            carthtml += '<div class="cart-product">' +
                '<a href="product-details.html" class="image"><img src="' + imglink + '" alt=""></a>' +
                '<div class="content">' +
                '<h3 class="title"><a href="product-details.html"> ' + cart_data.pname + '</a></h3>' +
                '<p class="price"><span class="qty">' + cart_data.quantity + ' ×</span> ' + currencySymbol + ' ' + cart_data.price + '</p>' +
                '<button class="cross-btn item-remove" data-id="' + x + '"><i class="fas fa-times "></i></button>' +
                '</div>' +
                '</div>';
        }
        carthtml += '</div> <!-- single-cart-block -->';

        carthtml += '<div class=" single-cart-block ">' +
            '<div class="btn-block">' +
            '<a href="' + cartUrl + '" class="btn">View Cart <i class="fas fa-chevron-right"></i></a>' +
            '<a href="' + checkoutUrl + '" class="btn btn--primary">Check Out <i class="fas fa-chevron-right"></i></a>' +
            '</div>' +
            '</div>';

    } else {
        carthtml += '<h3 class="text-center">Your cart is empty!</h3>';
    }

    save_cart_data();
    $('.shopping-cart').html(carthtml);
    $('.text-number').html(item_qty);
    $('.cart_total').html(currencySymbol + ' ' + cart_total);


}

function generateCartPageHtml() {
    var cartHTML = '';
    if (cart.length < 1) {
        cartHTML += '<tbody><tr><td colspan="5"><h3>There is no item in cartdd!</h3></td></tr></tbody>';
    } else {
        cartHTML += '<thead><tr>' +
            '<th class="pro-remove"></th>' +
            '<th class="pro-thumbnail">Image</th>' +
            '<th class="pro-title">Product</th>' +
            '<th class="pro-price">Price</th>' +
            '<th class="pro-quantity">Quantity</th>' +
            '<th class="pro-subtotal">Total</th>' +
            '</tr></thead>';
        for (var k = 0; k < cart.length; k++) {
            var single_item = cart[k];
            cartHTML += '<tr>' +
                '<td class="pro-remove"><a href="#" class="btn-remove" data-id="' + k + '"><i class="far fa-trash-alt"></i></a>' +
                '</td>' +
                '<td class="pro-thumbnail"><a href="#"><img src="' + single_item.image + '" alt="Product"></a></td>' +
                '<td class="pro-title"><a href="#">' + single_item.pname + '</a></td>' +
                '<td class="pro-price"><span>' + currencySymbol + ' ' + single_item.price + '</span></td>' +
                '<td class="pro-quantity">' +
                '<div class="pro-qty">' +
                '<div class="count-input-block">' +
                '<button class="btn-cart-qty btn-cart-plus" data-id="' + k + '"><i class="fa fa-plus"></i></button>' +
                '<input type="number" readonly class="form-control text-center" value="' + single_item.quantity + '">' +
                '<button class="btn-cart-qty btn-cart-minus" data-id="' + k + '"><i class="fa fa-minus"></i></button>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="pro-subtotal"><span>' + currencySymbol + ' ' + (single_item.price * single_item.quantity).toFixed(2) + '</span></td>' +
                '</tr>';

        }
    }
    $('#cart_table').html(cartHTML);
}


$('.cleardata').on("click", function() {
    cart = [];
    generateCartHtml();
});


$('.shopping-cart').on('click', '.item-remove', function() {
    var cartIndex = $(this).data('id');
    cart.splice(cartIndex, 1);
    generateCartHtml();
});


$('#cart_table').on('click', '.btn-remove', function() {
    var cartIndex = $(this).data('id');
    cart.splice(cartIndex, 1);
    save_cart_data();
    generateCartPageHtml();
});


$('#cart_table').on('click', '.btn-cart-plus', function() {
    var cartIndex = $(this).data('id');
    cart[cartIndex].quantity = Number(cart[cartIndex].quantity) + 1;
    save_cart_data();
    generateCartPageHtml();
});


$('#cart_table').on('click', '.btn-cart-minus', function() {
    var cartIndex = $(this).data('id');
    if (cart[cartIndex].quantity == 1) {
        cart.splice(cartIndex, 1);
    } else {
        cart[cartIndex].quantity = Number(cart[cartIndex].quantity) - 1;
    }
    save_cart_data();
    generateCartPageHtml();
});


function cartSummery() {
    let cartSummeryHtml = '';
    cartSummeryHtml += '<div class="cart-summary">' +
        '<div class="cart-summary-button">' +
        '<a href="' + checkoutUrl + '" class="checkout-btn c-btn btn--primary">Checkout</a>' +
        '</div>' +
        '</div>';

    $('#cart_summery').html(cartSummeryHtml);
}


function save_cart_data() {
    var data = {
        "cart_data": cart
    }
    $.ajax({
        url: storeCartUrl,
        type: 'POST',
        data: data,
        success: function(response) {
        }
    });
}   
