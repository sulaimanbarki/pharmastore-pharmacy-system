<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use App\Orders;
use App\Product;
use App\User;
use App\Settings;
use Auth;
use Illuminate\Support\Facades\DB as FacadesDB;

class adminHomeController extends Controller
{
   public function index(){
  		$orders = Orders::where('status',1)->count();
  		$categories = Category::where('status',1)->count();
  		$products = Product::where('status',1)->count();
  		$users = User::where('status',1)->count();
          
        $orderList = DB::table('orders')
			    ->whereRaw('DATE(created_at) = ?', Date("Y-m-d"))
			    ->where('status', 1)
			    ->latest('grandtotal')
			    ->select("*")
			    ->take(10)
                ->get();
        $today = date("Y-m-d");
		$lastTenDays = date("Y-m-d", strtotime("-17 days"));
		
		$newProducts = DB::table('product')
			    ->where('status', 1)
				->select("*")
				->take(10)
                ->get();
				
			

		$settings = Settings::first();

		$monthlysales= DB::table('orders')
						->selectRaw('DATE_FORMAT(created_at, "%b-%y") AS month, grandtotal as total')
						->whereRaw('created_at <= NOW() and created_at >= Date_add(Now(),interval - 12 month)')
						->orderByRaw('DATE_FORMAT(created_at, "%y-%m")')
                        ->get();
        $monthlySalesData = array();
        if($monthlysales){
            $monthlysales = $monthlysales->toArray();
            foreach($monthlysales as $key=>$saleData){
                if(isset($monthlySalesData[ $saleData->month ])){
                    $monthlySalesData[ $saleData->month ] += $saleData->total;
                }
                else{
                    $monthlySalesData[ $saleData->month ] = $saleData->total;
                }
            }
        }
		
   		return view('admin.home.homeContents',['categories' => $categories, 'products' => $products, 'orders' => $orders, 'users' => $users, 'orderList' => $orderList, 'settings' => $settings, 'newProducts' => $newProducts, 'monthlysales' => $monthlySalesData]);
   }

   public function logout(){
   		Auth::logout();
   		return redirect('/admin/login');
   }
}
