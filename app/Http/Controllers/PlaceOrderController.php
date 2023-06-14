<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Settings;
use App\Discount;
use App\PaymentMethod;
use App\User;
use App\Orders;
use App\Order_Product;
use Auth;
use DB;

class PlaceOrderController extends Controller
{
    public function index(){
        $allproducts = Product::where('status', 1)->get();
    	$products = [];
    	$settings = Settings::first();
    	return view('admin.Order.add',['products' => $products,'all_products'=>$allproducts, 'settings' => $settings]);
    }

    public function new(){  
        //GET MEDICINE LIST      
        $medicines = Product::where('status', 1)->get();

        //GENERATE ORDER NUMBER
        $digits = 6;
        $orderNumber = 'ORD-'.rand(pow(10, $digits-1), pow(10, $digits)-1);

        //GET SETTINGS
        $settings = Settings::first();

        //SHOW ORDER TEMPLATE
        return view('admin.Order.orderTemplate',['order_number' => $orderNumber, 'medicines' => $medicines, 'settings' => $settings]);
    }


    public function saveOrder(Request $request){
        //FETCH ORDER NUMBER
        $orderNumber = $request->order_number;
                
        //TOTALS
    	$sub_total = $request->sub_total;
    	$discount_amount = $request->discount_amount;
    	$tax_amount = $request->tax_amount;
        $total_amount = $request->total_amount;
    	$discountType = $request->discountType;
        
        //SAVE THE ORDER
        $newOrder = new Orders();
        $newOrder->order_number = $orderNumber;
        $newOrder->payment_type = $request->payment;
        $newOrder->payment_status = "paid";
        $newOrder->subtotal = $request->sub_total;
        $newOrder->total_discount = $request->discount_amount;
        $newOrder->delivery_charge = $$request->delivery_Charge ?? 0;
        $newOrder->grandtotal = $request->total_amount;
        $newOrder->status = 1;
        $newOrder->order_by = Auth::user()->id;
        $newOrder->save();

        //FETCH ITEM DETAILS
    	$product = $request->product;
    	$qty = $request->qty;
        $price = $request->price;
        $total = $request->total;
        $discountType = $request->discountType;
    	$discount = $request->discount;
        $grandTotal = $request->grandtotal;

        //ADD PRODUCTS AGAINST THE ORDER ID
        $products = array();
        foreach($request->product as $key => $value) {
            $products[] = new Order_Product([
                'product_id' => $product[ $key], 
                'qty' => $qty[ $key ], 
                'price' => $price[ $key ],
                'total' => $total[ $key ],
                'discount_type' => $discountType[ $key ],
                'discount' => $discount[ $key ],
                'grand_total' => $grandTotal[ $key ],
            ]);
        }
        $newOrder->products()->saveMany($products);
        
        //RETURN TO ORDER LIST
        return redirect('/order/list');
    }

    public function search(Request $request){
        $allproducts = Product::where('status', 1)->get();
    	$products = Product::where('name', 'LIKE', '%'.$request->name.'%')->where('status', 1)->get();
    	$settings = Settings::first();
    	//
    	foreach ($products as $key => $product){
    		$discount = Discount::where('product_id', $product->id)->where('status', 1)->first();
    		if (!empty($discount)){
    			$products[$key]["discount"] = $discount;
    		}else{
    			$products[$key]["discount"] = [];
    		}
	    }
	   

    	return view('admin.Order.add',['products' => $products,'all_products'=>$allproducts, 'settings' => $settings]);
    }
    public function checkouts($array){
         
        $products = json_decode($array, true);
        $totalDiscount = 0;
        
        $subTotal = 0;
        $grandTotal = 0;
        foreach ($products as $key => $value) {
            $product = Product::where('id', $value["id"])->where('status', 1)->first();
            $discount = Discount::where('product_id', $value["id"])->where('status', 1)->first();
            $products[$key]["subtotal"] = $product->sellingPrice * $value["count"];
            $products[$key]["discount"] = [];
            $products[$key]["grandtotal"] = $product->sellingPrice * $value["count"];

            $products[$key]["discountAmt"] = 0;
            $subTotal += $products[$key]["subtotal"];
            if (!empty($discount)){
                $products[$key]["discount"] = $discount;
                  if($discount->type == "percentage"){
                      $totalDiscount += (($discount->amount/100) * ($product->sellingPrice)*$value["count"]);
                      $products[$key]["discountAmt"] = ($discount->amount/100) * ($product->sellingPrice);
                  }else{
                      $totalDiscount  += ($discount->amount * $value["count"]);
                      $products[$key]["discountAmt"]  = $discount->amount;
                  }
                $products[$key]["grandtotal"] = ($product->sellingPrice * $value["count"]) - ($products[$key]["discountAmt"]*$value["count"]);    
            }
            $grandTotal += $products[$key]["grandtotal"];
        }
        
       
        $settings = Settings::first();
       

        $d = [];
        if($totalDiscount <= 0){
            $d = $this->discountCalculation();

            if($d->type == "percentage"){
                  $totalDiscount = (($d->amount/100) * $subTotal);
              }else{
                  $totalDiscount  = ($discount->amount * $subTotal);
              }
        }
        

        $settings = Settings::first();
        $delivery_Charge = $settings->delivery_charge;
        $grandTotal += $delivery_Charge;
        
        $cart = [
                "products" => $products,
                "grandTotal" => $grandTotal,
                "subTotal" => $subTotal,
                "delivery_Charge" => $delivery_Charge,
                "totalDiscount" => $totalDiscount,
                "totalDiscount" => $totalDiscount,
                "discount" => $d,
        ];
        session()->put('cart', $cart);
        $payments = PaymentMethod::where('status', 1)->get();
        $users = User::where('status', 1)->get();
        return view('admin.Order.checkout',['products' => $cart, 'settings' => $settings, 'payments' => $payments, 'users' => $users]);
        
    }
    public function checkout(){
        $settings = Settings::first();
        $payments = PaymentMethod::where('status', 1)->get();
        $users = User::where('status', 1)->get();
        $order_policy = DB::table('order_policy')->get();
        return view('admin.Order.checkout',['settings' => $settings, 'payments' => $payments, 'users' => $users, 'order_policy' => $order_policy]);
    }
    
    
    function placeOrder(Request $request){
        
        $validatedData = $request->validate([
            'user' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'postcode' => 'required',
            'payment' => 'required'
        ]);

        $payment = PaymentMethod::where('id', $request->payment)->first();

        $products = $request->products;
        $digits = 7;
        $order_number = 'INV'.rand(pow(10, $digits-1), pow(10, $digits)-1);
        $cart = $this->createCart($products,$order_number);

        $settings = Settings::first();
        $delivery_Charge = $settings->delivery_charge;

        $datas = new Orders();
        $datas->order_id = $order_number;
        $datas->customer_id = $request->user;
        $datas->customer_name = $request->name;
        $datas->customer_email = $request->email;
        $datas->customer_phone = $request->phone;
        $datas->customer_postcode = $request->postcode;
        $datas->customer_address = $request->address;
        $datas->customer_city = $request->city;
        $datas->customer_country = $request->country;
        $datas->payment_type = $request->payment;
        $datas->subtotal = $cart["subTotal"];
        $datas->total_discount = $cart["totalDiscount"];
        $datas->others_discount_id = !empty($cart["non_product_discount"]) ? $cart["non_product_discount"]->id : 0;
        $datas->delivery_charge = $delivery_Charge;
        $datas->grandtotal = $cart["grandTotal"];
        $datas->status = 1;
        $datas->order_by = Auth::user()->email;
        $datas->order_date = Date("Y-m-d");


       
        session()->put('cart', $cart);
       
        if($payment->type == "Cash"){
            
            if(!empty($cart)){
                $datas->payment_status = "succeeded";
                $datas->save();
                $this->storePaymentInfo($cart, $datas);
            }
          return redirect('/order/confirm')->with('message','Place Order Successfully.');

        }else{

            \Stripe\Stripe::setApiKey('sk_test_INKTB17BzoQl2Acim6bpUqCw00pXHWcYwU');

            // Token is created using Checkout or Elements!
            // Get the payment token ID submitted by the form:
            $token = $_POST['stripeToken'];
            $charge = \Stripe\Charge::create([
                'amount' => $datas->grandtotal*100,
                'currency' => 'usd',
                'description' => 'Example charge',
                'source' => $token,
            ]);

           
            if($charge->status == "succeeded" && $charge->paid == true){
                $datas->payment_status = $charge->status;
                $datas->card_charge_id = $charge->id;
                $datas->card_customer =  $charge->customer;
                $datas->card_paid = $charge->paid;
                $datas->card_payment_method = $charge->payment_method;
                $datas->save();
                $this->storePaymentInfo($cart, $datas);
                return redirect('/order/confirm')->with('message','Place Order Successfully.');
            }
                return redirect('/order/confirm')->with('error','Not Place Order Successfully.');
        }
    }

    public function create_customer(Request $request){
        
        $request->validate([
            'firstname_n'   => 'required',
            'lastname_n'    => 'required',
            'email_n'       => 'required|email|unique:users,email',
            'phone_n'       => 'required|min:11|unique:users,phone',
            'postcode_n'    => 'required'
        ]);

        $user = new User;
        $user->name         = $request->firstname_n.' '.$request->lastname_n;
        $user->firstname    = $request->firstname_n;
        $user->lastname     = $request->lastname_n;
        $user->email        = $request->email_n;
        $user->phone        = $request->phone_n;
        $user->postcode     = $request->postcode_n;
        $user->password     = bcrypt($request->phone_n);
        $user->users_role_id= 4;
        $user->isAdmin      = 0;
        $user->status       = 1;

        try{
            $user->save();
            session()->flash('message','User created successfully');
            session()->flash('type','success');
            
            return redirect()->back();
        }catch(Exception $e){
            session()->flash('message',$e->getMassage());
            session()->flash('type','danger');
            return redirect()->back();
        }
    }

    function storePaymentInfo($cart, $datas){
        if(count($cart["productArr"])>0){
            DB::table('order_products')->insert($cart["productArr"]);
            foreach ($cart["productArr"] as $key => $value) {
               $quantity = $value["qty"];
               $product = Product::find($value["product_id"]);
               $totalPurchedItem = $product->totalPurchedItem;
               $itemsSaleCount = $product->itemsSaleCount + $quantity;
               if($totalPurchedItem >= $itemsSaleCount){
                    $product->itemsSaleCount = $itemsSaleCount;
                    $product->save();
               }

            }
            
        }
    }
    public function confirm(){
        $cart = session()->get('cart');
        session()->forget('cart');
        
        
        $settings = Settings::first();
        if(isset($cart)){
            return view('admin.Order.confirmOrder',['cart' => $cart, 'settings' => $settings]);
        }else{
                return redirect('/order/');
        }
    }
    private function createCart($products, $order_number){
        $settings = Settings::first();
        $delivery_Charge = $settings->delivery_charge;
        $totalDiscount = 0;
        $subTotal = 0;
        $grandTotal = 0;
        $cartItem = [];
        foreach ($products as $key => $value) {
            $val = explode('_', $value);
            $id = $val[0];
            $qty = $val[1];
            $product = Product::where('id', $id)->where('status', 1)->first();
            $totalPurchedItem = $product->totalPurchedItem;
            $itemsSaleCount = $product->itemsSaleCount + $qty;
            // check  product is not out of stock
            if($totalPurchedItem >= $itemsSaleCount){
                $discount = Discount::where('product_id', $id)->where('status', 1)->first();
                $product->subtotal = $product->sellingPrice * $qty;
                $product->discount = [];
                $product->grandtotal = $product->sellingPrice * $qty;

                $product->discountAmt = 0;
                $subTotal += $product->subtotal;
                if (!empty($discount)){
                    $product->discount = $discount;
                      if($discount->type == "percentage"){
                          $totalDiscount += (($discount->amount/100) * ($product->sellingPrice)*$qty);
                          $product->discountAmt = ($discount->amount/100) * ($product->sellingPrice);
                      }else{
                          $totalDiscount  += ($discount->amount * $qty);
                          $product->discountAmt  = $discount->amount;
                      }
                    $product->grandtotal = ($product->sellingPrice * $qty) - ($product->discountAmt*$qty);    
                }
                $grandTotal += $product->grandtotal;
                array_push($cartItem,$product);
                $productArr[] = [
                    'order_id' => $order_number,
                    'product_id' => $id,
                    'qty' => $qty,
                    'discount_id' => isset($discount) ? $discount->id : 0,
                ];

                $carttArr[] = [
                    'order_id' => $order_number,
                    'product_id' => $id,
                    'product_name' => $product->name,
                    'unit_price' => $product->sellingPrice,
                    'discount_type' => (!empty($discount)) ? $discount->type: "",
                    'discount_amount' => (!empty($discount)) ? $product->discountAmt: 0,
                    'discount_value' => (!empty($discount)) ? $discount->amount: 0,
                    'qty' => $qty,
                    'discount_id' => isset($discount) ? $discount->id : 0,
                ];
            }
            
        }

        $d = [];
        if($totalDiscount <= 0){
            $d = $this->discountCalculation();

            if($d->type == "percentage"){
                  $totalDiscount = (($d->amount/100) * $subTotal);
              }else{
                  $totalDiscount  = ($discount->amount * $subTotal);
              }
        }
        
        
        $grandTotal += $delivery_Charge;
        $cart = [
                "products" => $cartItem,
                "grandTotal" => $grandTotal,
                "subTotal" => $subTotal,
                "delivery_Charge" => $delivery_Charge,
                "totalDiscount" => $totalDiscount,
                "totalDiscount" => $totalDiscount,
                "non_product_discount" => $d,
                "productArr" => isset($productArr) ? $productArr : [],
                "carttArr" => isset($carttArr) ? $carttArr : [],
        ];

        return $cart;
    }

    public function list(){
        $orders = Orders::paginate(10);
        $settings = Settings::first();
        return view('admin.Order.list',['orders' => $orders, 'settings' => $settings]);
    }

    public function updateOrderStatus($id, $status){
        $order = Orders::find($id);
        if($status == "pending"){
          $order->status = "1";
        }else if($status == "delivered"){
          $order->status = "2";
        }if($status == "reject"){
          $order->status = "3";
        }
        $order->save();
        return redirect('/order/list')->with('message','Updated Successfully.');
    }

    public function details($id){ 
        $order = Orders::where('order_id', $id)->first();
        $settings = Settings::first();
        $products = DB::table('order_products')->where('order_id', $order->order_id)->get();
                
        return view('admin.Order.details',['order' => $order, 'products' => $products, 'settings' => $settings]);
    }

    public function addToCart($id){
        $product = Product::where('id', $id)->where('status', 1)->first();

        if(!$product) {
 
            abort(404);
 
        }
 
        $cart = session()->get('cart');
 
        // if cart is empty then this the first product
        if(!$cart) {
 
            $cart = [
                    $id => [
                        "name" => $product["name"],
                        "quantity" => 1,
                        "sellingPrice" => $product["sellingPrice"],
                        "image" => $product["image"]
                    ]
            ];
 
            session()->put('cart', $cart);
 
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
 
        // if cart not empty then check if this product exist then increment quantity
        if(isset($cart[$id])) {
 
            $cart[$id]['quantity']++;
 
            session()->put('cart', $cart);
 
            return redirect()->back()->with('success', 'Product added to cart successfully!');
 
        }
 
        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
             "name" => $product["name"],
            "quantity" => 1,
            "sellingPrice" => $product["sellingPrice"],
            "image" => $product["image"]
        ];
 
        session()->put('cart', $cart);
 
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
    public function update(Request $request)
    {
        if($request->id and $request->quantity)
        {
            $cart = session()->get('cart');
 
            $cart[$request->id]["quantity"] = $request->quantity;
 
            session()->put('cart', $cart);
 
            session()->flash('success', 'Cart updated successfully');
        }
    }
 
    public function remove(Request $request)
    {
        if($request->id) {
 
            $cart = session()->get('cart');
 
            if(isset($cart[$request->id])) {
 
                unset($cart[$request->id]);
 
                session()->put('cart', $cart);
            }
 
            session()->flash('success', 'Product removed successfully');
        }
    }
}
