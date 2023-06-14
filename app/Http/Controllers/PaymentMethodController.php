<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentMethod;
use App\PublishName;
use DB;
use Auth;

class PaymentMethodController extends Controller
{
    public function index(){

    	$listData = DB::table('payment_methods')->paginate(5);

        $publish = PublishName::all();

    	return view('admin.PaymentMethod.payment',['listData' => $listData, 'publish' => $publish]);

    }

    public function save(Request $request){

        $validatedData = $request->validate([
            'type' => 'required|unique:payment_methods',
            'status' => 'required',
            'image' => 'required',
        ]);

    	$datas = new PaymentMethod();

        $datas->type = $request->type;

        $datas->image = 'image';

    	$datas->status = $request->status;

        $datas->created_by = Auth::user()->id;

        $datas->updated_by = Auth::user()->id;

        $findVal = PaymentMethod::where('type' , '=', $request->type)->first();

         if(!$findVal) {

            $datas->save();

            $imgInfo = $request->file('image');

            if(isset($imgInfo)){

                $lastId = $datas->id;

                $imgName = $lastId.$imgInfo->getClientOriginalName();

                $folderName = 'projectImage/payments/';

                $imgInfo->move($folderName, $imgName);

                $imgUrl = $folderName.$imgName;

                // update image name
                $img = PaymentMethod::find($lastId);

                $img->image = $imgUrl;

                $img->save();

            }
            
            return redirect('/paymentmethods/')->with('message','Inserted Successfully.');

        } else{

            return redirect('/paymentmethods/')->with('error','Already Exists.');

        }
    }

    public function edit($id){

    	$listData = DB::table('payment_methods')->paginate(5);

        $publish = PublishName::all();

        $editData = PaymentMethod::where('id', $id)->first();
        
        return view('admin.PaymentMethod.payment',['editData' => $editData, 'listData' => $listData, 'publish' => $publish]);

    }

    public function update(Request $request){

       $validatedData = $request->validate([
            'type' => 'required'
        ]);

        $datas = PaymentMethod::find($request->id);

        $datas->type = $request->type;

    	$datas->status = $request->status;

        $datas->updated_by = Auth::user()->id;


        $dataExists = PaymentMethod::where('type', $request->type)->first();

        if($dataExists && $request->id != $dataExists->id) {

            return redirect('/paymentmethods/edit/'.$request->id.'')->with('error',''.$request->type.' Has Already Been Taken.');

        }

        if($datas->count() > 0) {

            $imgInfo = $request->file('image');

            if(isset($imgInfo)){

                if(file_exists($datas->image)){

                    unlink($datas->image);

                }

                $lastId = $request->catID;

                $imgName = $lastId.$imgInfo->getClientOriginalName();

                $folderName = 'projectImage/payments/';

                $imgInfo->move($folderName, $imgName);

                $imgUrl = $folderName.$imgName;

                $datas->image = $imgUrl;

                $datas->save();

            }else{

                $datas->save();

            }

            return redirect('/paymentmethods/')->with('message','Updated Successfully.');

        } else{

            return redirect('/paymentmethods/')->with('error','Not Updated Successfully.');

        }

    }

    public function delete($id){

        $datas = PaymentMethod::find($id);

        $datas->delete();

        return redirect('/paymentmethods/')->with('message','Deleted Successfully.');

    }
    
    public function publishStatus($status, $id){

        $datas = PaymentMethod::find($id);

        $publish = PublishName::where('name', $status)->first();

        $datas->status = $publish->id;

        $datas->save();

        return redirect('/paymentmethods/')->with('message','Updated Successfully.');
    }
}
