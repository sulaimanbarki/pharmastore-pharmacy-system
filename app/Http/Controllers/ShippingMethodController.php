<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShippingMethod;
use App\PublishName;
use DB;
use Auth;

class ShippingMethodController extends Controller
{
    public function index(){

    	$listData = DB::table('shipping_methods')->paginate(5);

        $publish = PublishName::all();

    	return view('admin.Shipping.shipping',['listData' => $listData, 'publish' => $publish]);
    }

    public function save(Request $request){

        $validatedData = $request->validate([
            'type' => 'required|unique:payment_methods',
            'status' => 'required'
        ]);

    	$datas = new ShippingMethod();

        $datas->type = $request->type;

    	$datas->status = $request->status;

    	$datas->created_by = Auth::user()->id;

        $datas->updated_by = Auth::user()->id;

        $findVal = ShippingMethod::where('type' , '=', $request->type)->first();

         if(count($findVal) == 0) {
            $datas->save();
            
            return redirect('/shipping/')->with('message','Inserted Successfully.');

        } else{

            return redirect('/shipping/')->with('error','Already Exists.');
        }
    }

    public function edit($id){

    	$listData = DB::table('shipping_methods')->paginate(5);

        $editData = ShippingMethod::where('id', $id)->first();

        $publish = PublishName::all();

        return view('admin.Shipping.shipping',['editData' => $editData, 'listData' => $listData, 'publish' => $publish]);
    }

    public function update(Request $request){

       $validatedData = $request->validate([
            'type' => 'required'
        ]);

        $datas = ShippingMethod::find($request->id);

        $datas->type = $request->type;

    	$datas->status = $request->status;

        $datas->updated_by = Auth::user()->id;


        $dataExists = ShippingMethod::where('type', $request->type)->first();

        if(count($dataExists) > 0 && $request->id != $dataExists->id) {

            return redirect('/shipping/edit/'.$request->id.'')->with('error',''.$request->type.' Has Already Been Taken.');

        }

        if(count($datas) > 0) {

            $datas->save();

            return redirect('/shipping/')->with('message','Updated Successfully.');

        } else{

            return redirect('/shipping/')->with('error','Not Updated Successfully.');
        }

    }
    public function delete($id){

        $datas = ShippingMethod::find($id);

        $datas->delete();

        return redirect('/shipping/')->with('message','Deleted Successfully.');

    }
    public function publishStatus($status, $id){

        $datas = ShippingMethod::find($id);

        $publish = PublishName::where('name', $status)->first();

        $datas->status = $publish->id;

        $datas->save();

        return redirect('/shipping/')->with('message','Updated Successfully.');
    }
}
