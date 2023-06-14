<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Discount;
use App\Mail\AdminOrderMail;
use App\Mail\OrderMail;
use App\Order_Product;
use App\Orders;
use App\PaymentMethod;
use App\Product;
use App\Settings;
use App\User;
use App\Client;
use App\Payment;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Stripe\Customer;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $settings = Settings::first();

        $discounts= Discount::where('status',1)->get();

        $products= Product::where('status','=',1)->get();

        $categories= Category::Where('status',1)->get(); 

        return view('welcome1',compact('products','categories','discounts','settings'));

    }

    public function category_product($id){

        $products= Product::where('category_id',$id)->get();

        $categories= Category::Where('status',1)->get(); 

        return view('frontend.category_product',compact('products','categories'));

    }

    public function group_product($id){

        $products= Product::where('group_id',$id)->get();

        $categories= Category::Where('status',1)->get(); 

        return view('frontend.group_product',compact('products','categories'));

    }

    public function product_details($id){

        $product= Product::find($id);

        $categories= Category::Where('status',1)->get();

        return view('frontend.product_details',compact('product','categories'));

    }

    public function about_us(){

        $categories= Category::Where('status',1)->get();

        return view('frontend.about_us',compact('categories'));

    }



    public function cart(Request $request){

        $cart_items=$request->session()->get('cart_data');

        if(!$cart_items){

            return redirect()->route('main_home');

        }
        
        $cart_data= $this->get_cart_data($cart_items);

        
        $settings = Settings::first();

        $delivery_charge = $settings == NULL ? $settings->delivery_charge ?? 0 : 0;

        $categories= Category::Where('status',1)->get();

        return view('frontend.cart',compact('categories','delivery_charge','cart_items','cart_data','settings'));

    }

    public function store_cart_data(Request $request){

         $request->session()->put('cart_data',$request->cart_data);

    }

    public function checkout(Request $request){

        $cart_items=$request->session()->get('cart_data');

        $cart_data= $this->get_cart_data($cart_items);


        $settings = Settings::first();

        $delivery_charge = $settings == NULL ? 0 : $settings->delivery_charge ?? 0  ;

        $categories= Category::Where('status',1)->get();

        $payment_methods= PaymentMethod::where('status',1)->get();

        return view('frontend.checkout',compact('payment_methods','categories','delivery_charge','cart_data','settings'));

    }

    public function orderprocess(Request $request){

        $settings = Settings::first();

        $delivery_charge = $settings == NULL ? 0 : $settings->delivery_charge ?? 0  ;


        $cartData=$request->session()->get('cart_data');        

        $request->validate([
            'firstname'     => 'required',
            'lastname'      => 'required',
            'country'       => 'required',
            'email'         => 'required|email',
            'phone'         => 'required|min:11',
            'address'       => 'required',
            'city'          => 'required',
            'postcode'      => 'required',
            'isagree'       => 'required',
            'payment_method'       => 'required',
        ],
        [
            'isagree.required'  =>'Please accept the terms and conditions'
        ]
    );


    //CHECK IF SAME EMAIL HAS BEEN USED TO PLACE ORDER BEFORE
    $client = Client::where('email','=',$request->email)->first();


    //SAVE NEW CUSTOMER
    if(!$client){ 

        $client = new Client;

        $client->first_name = $request->firstname;

        $client->last_name = $request->lastname;

        $client->email = $request->email;

        $client->phone = $request->phone;

        $client->zip = $request->postcode;

        $client->address = $request->address;

        $client->city = $request->city;

        $client->country = $request->country;

        $client->save();        
    }


    $cart_data = $this->get_cart_data($cartData);

    $digits = 7;

    $order_number = 'ORD-'.rand(pow(10, $digits-1), pow(10, $digits)-1);

    $datas = new Orders();

    $datas->order_number = $order_number;

    $datas->customer_id = $client->client_id;

    $datas->payment_type = $request->payment_method;

    $datas->subtotal = $cart_data['subtotal'];

    $datas->total_discount = $cart_data['discount'];

    $datas->delivery_charge = $delivery_charge;

    $datas->grandtotal = $cart_data['grandtotal'] + $delivery_charge;

    $datas->status = 1;

    $datas->order_by = $client->email;

    if($request->payment_method==2){
        // cash payment method

        $datas->payment_status = "succeeded";

        $datas->save();

        if($datas->save()){

            $this->save_ordered_item($cartData, $datas);

            session()->flash('message','Order placed successfully');

            session()->flash('type','success');
           
            Mail::to('sumona.uiu@gmail.com')->send(new OrderMail($datas));

            return redirect()->route('order_success',$datas->order_id);

        }else{

            session()->flash('message','Order not placed!');

            session()->flash('type','danger');

            return redirect()->route('order_failed');

        } 

    }elseif($request->payment_method==1){
        // card payment method

        \Stripe\Stripe::setApiKey('sk_test_Pp8YDiX5yhiWEQ9vYUnYUqYY00LqkL3mhr');

        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:
        $token = $_POST['stripeToken'];

        $charge = \Stripe\Charge::create([
            'amount' => $datas->grandtotal*100,
            'currency' => 'usd',
            'description' => 'Example charge',
            'source' => $token,
            "metadata" => ["card_customer_name" => $request->card_customer_name]
        ]);

        if($charge->status == "succeeded" && $charge->paid == true){

            $datas->payment_status = $charge->status;

            //SAVE PAYMENT RECORD IN DATABASE
            $payment = new Payment();

            $payment->card_customer =  $charge->metadata->card_customer_name;

            $payment->card_charge_id = $charge->id;

            $payment->card_paid = $charge->paid;

            $payment->card_payment_method = $charge->payment_method;

            $payment->save();

            //ATTACH PAYMENT ID WITH ORDER
            $datas->payment_id = $payment->payment_id;

            //SAVE ORDER
            if($datas->save()){

                $this->save_ordered_item($cartData, $datas);

                session()->flash('message','Order placed successfully');

                session()->flash('type','success');
               
                Mail::to('sumona.uiu@gmail.com')->send(new OrderMail($datas));

                return redirect()->route('order_success',$datas->order_id);

            }else{

                session()->flash('message','Order not placed!');

                session()->flash('type','danger');

                return redirect()->route('order_failed');

            }
        }

    }


    }

    public function save_ordered_item($items, $order){

        $dataArr= array();

        foreach($items as $item){

            $dataArr[]= array(
                'order_id' => $order->order_id,
                'product_id' => $item['pid'],
                'qty' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['quantity'] * $item['price'], 
                'discount_type'   => 'fixed',
                'discount' => 0,
                'grand_total' => $item['quantity'] * $item['price']
            );

            // save product salse count
            $product = Product::find($item['pid']);

            $totalPurchedItem = $product->totalPurchedItem;

            $itemsSaleCount = $product->itemsSaleCount + $item['quantity'];

            if($totalPurchedItem >= $itemsSaleCount){

                 $product->itemsSaleCount = $itemsSaleCount;

                 $product->save();

            }

        }
    
        DB::table('order_products')->insert($dataArr);
    }

    public function order_success($order_id){

        $settings = Settings::first();

        Session::forget('cart_data');

        $order= Orders::where('order_id',$order_id)->first();

        $order_products= Order_Product::where('order_id',$order_id)->get();

        $delivery_charge = $settings == NULL ? $settings->delivery_charge ?? 0 : 0;

        $categories= Category::Where('status',1)->get();

        return view('frontend.order_success',compact('categories','order','order_products','delivery_charge','settings'));

    }

    public function order_failed(){

        $categories= Category::Where('status',1)->get();

        return view('frontend.order_failed',compact('categories'));

    }

    public function get_cart_data($items){

        $settings = Settings::first();

        $delivery_Charge = $settings == NULL ? $settings->delivery_charge??0 : 0;

        $subtotal= 0;

        $discount=0;

        foreach($items as $item){

            $discountData = Discount::where('product_id', $item['pid'])->where('status', 1)->first();
            
            if($discountData)
            {

               if($discountData->type=='percentage')

               {
                    
                    $each_discount= (($item['price'] * $discountData->amount) /100 ) * $item['quantity'];
               }
               else
               {
                    
                    $each_discount= ($discountData->amount * $item['quantity']);
               } 
               
               $discount+= $each_discount;
            }

            
            $subtotal+= $item['price'] * $item['quantity'];
        }
        
        $grandtotal= ($subtotal + $delivery_Charge) - $discount;

        $data['discount']= $discount;

        $data['subtotal']= $subtotal;

        $data['grandtotal']= $grandtotal;

        $data['delivery_charge']= $delivery_Charge;

        return $data;

    }


    public function search_product(Request $request)
    {
        
        //FIND PRODUCTS WHOSE NAME MATCHES WITH USER SEARCH
        $productsMatchingNames = Product::with('generic')
                        ->where('status',1)
                        ->where('name', 'like', '%'.$request->q.'%')
                        ->get();


        //GET PRODUCTS WHO'S GENERIC NAME MATCHES WITH USER SEARCH
        $productsMatchingGeneric = Product::whereHas('generic', function ($query) use ($request){
                                                        return $query->where('name','like','%'. $request->q .'%');
                                                    })
                                ->where('status',1)
                                ->get();


        //MERGE BOTH ARRAYS
        $products = $productsMatchingNames->merge($productsMatchingGeneric); 

        $categories= Category::Where('status',1)->get();      

        return view('frontend.search_product',compact('products','categories'));
    }

    
}
