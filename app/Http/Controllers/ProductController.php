<?php

namespace App\Http\Controllers;
use App\Category;
use App\Product;
use App\MedicineGroup;
use App\GenericNames;
use App\Supplier;
use App\Settings;
use App\PublishName;
use DB;
use Auth;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){

        $categories = Category::where('status','=',1)->get();

        $settings = Settings::first();

        $groups =  MedicineGroup::where('status','=',1)->get();

        $genericNames = GenericNames::where('status','=',1)->get();

        $companyNames = Supplier::where('status','=',1)->get();

        $publish = PublishName::all();

    	return view('admin.Product.add',['categories' => $categories, 'groups' => $groups, 'genericNames' => $genericNames, 'companyNames' => $companyNames, 'settings' => $settings, 'publish' => $publish]);
    }

    public function save(Request $request){


        $validatedData = $request->validate([
            'category' => 'required',
            'name' => 'required|unique:product',
            'groupName' => 'required',
            'purchasePrice' => 'required',
            'sellingPrice' => 'required',
            'storeBox' => 'required',
            'itemsNumber' => 'required',
            'genericName' => 'required',
            'companyName' => 'required',
            'expireDate' => 'required',
            'status' => 'required'
        ]);

    	$datas = new Product();

        $datas->category_id = $request->category;

        $datas->group_id = $request->groupName;

        $datas->name = $request->name;

        $datas->purchasePrice = $request->purchasePrice;

        $datas->sellingPrice = $request->sellingPrice;

        $datas->storeBox = $request->storeBox;

        $datas->itemsNumber = $request->itemsNumber;

        $datas->generic_id = $request->genericName;

        $datas->supplier_id = $request->companyName;

        $datas->description = $request->description;

        $datas->image = 'image';

        $datas->status = $request->status;

        $datas->created_by = Auth::user()->id;

    	$datas->totalPurchedItem = $request->storeBox * $request->itemsNumber;

        $datas->updated_by = Auth::user()->id;

        $datas->expireDate =  date('Y-m-d', strtotime(str_replace('-', '/', $request['expireDate'])));


        $findVal = Product::where('name' , '=', $request->name)->first();

        if(empty($findVal)) {

            $datas->save();

            $imgInfo = $request->file('image');

            if(isset($imgInfo)){

                $lastId = $datas->id;

                $imgInfo = $imgInfo;

                $imgName = $lastId.$imgInfo->getClientOriginalName();

                $folderName = 'projectImage/product/';

                $imgInfo->move($folderName, $imgName);

                $imgUrl = $folderName.$imgName;

                // update image name
                $medImg = Product::find($lastId);

                $medImg->image = $imgUrl;

                $medImg->save();
            }
            

            return redirect('/product/add')->with('message','Inserted Successfully.');

        } else{

            return redirect('/product/add')->with('error','Already Exists.');

        }
    }

    public function manage(){

        $listData = Product::paginate(10);

        $settings = Settings::first();

        return view('admin.Product.listmanage',['listData' => $listData, 'settings' => $settings]);
    }

    public function oneMonthToexpire(){

        $today = date("Y-m-d");

        $next_month = date("Y-m-d", strtotime("$today +1 month"));

        $listData = Product::whereBetween('expireDate', [$today, $next_month])->paginate(10);

        $settings = Settings::first();

        return view('admin.Product.list',['listData' => $listData, 'settings' => $settings]);
    }

    public function expired(){

        $today = date("Y-m-d");

        $prev_month = date("Y-m-d", strtotime("$today -1 month"));

        $listData = Product::whereBetween('expireDate', [$prev_month, $today])->paginate(10);

        $settings = Settings::first();

        return view('admin.Product.list',['listData' => $listData, 'settings' => $settings]);
    }

    public function stockOut(){

        $today = date("Y-m-d");

        $prev_month = date("Y-m-d", strtotime("$today -1 month"));

        $listData = Product::where('totalPurchedItem', '=', 0)->paginate(10);

        $settings = Settings::first();

        return view('admin.Product.list',['listData' => $listData, 'settings' => $settings]);
    }
    public function edit($id){

        $medicine = Product::where('id', $id)->first();

        $categories = Category::where('status','=',1)->get();

        $groups =  MedicineGroup::where('status','=',1)->get();

        $genericNames = GenericNames::where('status','=',1)->get();

        $companyNames = Supplier::where('status','=',1)->get();

        $settings = Settings::first();

        $publish = PublishName::all();

        return view('admin.Product.add',['categories' => $categories, 'groups' => $groups, 'genericNames' => $genericNames, 'companyNames' => $companyNames, 'medicine' => $medicine, 'settings' => $settings, 'publish' => $publish]);
    }

    public function restock($id){

        $medicine = Product::where('id', $id)->first();

        $categories = Category::where('status','=',1)->get();

        $groups =  MedicineGroup::where('status','=',1)->get();

        $genericNames = GenericNames::where('status','=',1)->get();

        $companyNames = Supplier::where('status','=',1)->get();

        $settings = Settings::first();

        return view('admin.Product.restock',['categories' => $categories, 'groups' => $groups, 'genericNames' => $genericNames, 'companyNames' => $companyNames, 'medicine' => $medicine, 'settings' => $settings]);
    }

    public function update(Request $request){

        $validatedData = $request->validate([
            'category' => 'required',
            'name' => 'required',
            'groupName' => 'required',
            'purchasePrice' => 'required',
            'sellingPrice' => 'required',
            'storeBox' => 'required',
            'itemsNumber' => 'required',
            'genericName' => 'required',
            'companyName' => 'required',
            'expireDate' => 'required',
            'status' => 'required'
        ]);

        $datas = Product::find($request->id);

        $datas->category_id = $request->category;

        $datas->group_id = $request->groupName;

        $datas->name = $request->name;

        $datas->purchasePrice = $request->purchasePrice;

        $datas->sellingPrice = $request->sellingPrice;

        $datas->storeBox = $request->storeBox;

        $datas->itemsNumber = $request->itemsNumber;

        $datas->generic_id = $request->genericName;

        $datas->supplier_id = $request->companyName;

        $datas->description = $request->description;

        $datas->status = $request->status;

        
        $datas->updated_by = Auth::user()->id;

        $datas->expireDate =  date('Y-m-d', strtotime(str_replace('-', '/', $request['expireDate'])));

        $findVal = Product::where('name' , '=', $request->name)->first();

        if(!empty($findVal)) {

           if($request->type == 'restock') {

                $datas->totalPurchedItem = $findVal->leftItems + ($request->storeBox * $request->itemsNumber);
            } 
        }
       
        if(!empty($findVal) && $request->id != $findVal->id) {

            return redirect('/product/edit/'.$request->catID.'')->with('error',''.$request->name.' Has Already Been Taken.');
        }

        if(!empty($datas)) {

            $imgInfo = $request->file('image');

            $datas->save();

            if(isset($imgInfo)){

                if(file_exists($datas->image)){

                    unlink($datas->image);

                }
                $lastId = $request->id;

                $imgInfo = $request->file('image');

                $imgName = $lastId.$imgInfo->getClientOriginalName();

                $folderName = 'projectImage/product/';

                $imgInfo->move($folderName, $imgName);

                $imgUrl = $folderName.$imgName;

                // update image name
                $medImg = Product::find($lastId);

                $medImg->image = $imgUrl;

                $medImg->save();

            }

            return redirect('/product/list')->with('message','Updated Successfully.');

        } else{

            return redirect('/product/add')->with('error','Not Updated Successfully.');

        }
    }

    public function updateStock(Request $request){

        $validatedData = $request->validate([
            'name' => 'required',
            'storeBox' => 'required',
            'itemsNumber' => 'required',
            'expireDate' => 'required',
        ]);

        $datas = Product::find($request->id);

        $datas->purchasePrice = $request->purchasePrice;

        $datas->sellingPrice = $request->sellingPrice;

        $datas->storeBox = $request->storeBox;

        $datas->itemsNumber = $request->itemsNumber;

        
        $datas->updated_by = Auth::user()->id;

        $datas->expireDate =  date('Y-m-d', strtotime(str_replace('-', '/', $request['expireDate'])));

        $findVal = Product::where('name' , '=', $request->name)->first();

        if(!empty($findVal)) {

           if($request->type == 'restock') {

                $datas->totalPurchedItem = $findVal->totalPurchedItem + ($request->storeBox * $request->itemsNumber);
            } 
        }

       
        if(!empty($findVal) && $request->id != $findVal->id) {

            return redirect('/product/edit/'.$request->catID.'')->with('error',''.$request->name.' Has Already Been Taken.');
        }

        if(!empty($datas)) {

            $imgInfo = $request->file('image');

            $datas->save();

            if(isset($imgInfo)){

                if(file_exists($datas->image)){

                    unlink($datas->image);
                }

                $lastId = $request->id;

                $imgInfo = $request->file('image');

                $imgName = $lastId.$imgInfo->getClientOriginalName();

                $folderName = 'projectImage/product/';

                $imgInfo->move($folderName, $imgName);

                $imgUrl = $folderName.$imgName;

                // update image name
                $medImg = Product::find($lastId);

                $medImg->image = $imgUrl;

                $medImg->save();

            }

            return redirect('/product/list')->with('message','Updated Successfully.');

        } else{

            return redirect('/product/add')->with('error','Not Updated Successfully.');
        }
    }
    public function delete($id){

        $medicine = Product::find($id);

        $medicine->delete();

        if(file_exists($medicine->image)){

            unlink($medicine->image);
            
        }  
        return redirect()->back()->with('message','Deleted Successfully.');
    }
    public function publishStatus($status, $id){

        $medicine = Product::find($id);

        $publish = PublishName::where('name', $status)->first();

        $medicine->status = $publish->id;

        $medicine->save();

        return redirect()->back()->with('message','Updated Successfully.');
    }
    public function details($id){

        $medicine = Product::where('id', $id)->first();

        $settings = Settings::first();

        return view('admin.Product.details',['medicine' => $medicine, 'settings' => $settings]);
    }

    public function get_groups_by_categoryid(Request $request){

        $groups= MedicineGroup::where('category_id',$request->category_id)->get();  

        return response()->json($groups);
    }
}
