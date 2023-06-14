<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Email</title>
</head>
<body>
    <h1>An Order has been placed!</h1>


    <h2>Order Item</h2>
    <br>
    <table>
        <tr>
            <td>SL No</td>
            <td>Product Name</td>
            <td>Price</td>
            <td>Quantity</td>
            <td>Total</td>
        </tr>
        @foreach($data->products as $key=> $product)
        <tr>
            <td>{{$key}}</td>
            <td>{{$product->product->name}}</td>
            <td>{{$product->qty}}</td>
            <td>{{$product->product->sellingPrice}}</td>
            <td>{{ ($product->product->sellingPrice* $product->qty)}}</td>
        </tr>
        @endforeach
    
        <tr>
            <td colspan="4">Sub Total</td>
            <td>{{$data->subtotal}}</td>        
        </tr>
        <tr>
            <td colspan="4">Discount</td>
            <td>{{$data->total_discount}}</td>        
        </tr>
        <tr>
            <td colspan="4">Delivery Charge</td>
            <td>{{$data->delivery_charge}}</td>        
        </tr>
        <tr>
            <td colspan="4">Grand Total</td>
            <td>{{$data->grandtotal}}</td>        
        </tr>
    </table>
</body>
</html>


