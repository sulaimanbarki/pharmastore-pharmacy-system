<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use App\Medicine;
use App\Product;
use App\PublishName;
use DB;
use Auth;

class SupplierController extends Controller
{
    public function index(){

        $publish = PublishName::all();

    	return view('admin.Supplier.SupplierAdd',['publish' => $publish]);
    }

    public function save(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|unique:supplier',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

    	$datas = new Supplier();

        $datas->name = $request->name;

        $datas->email = $request->email;

        $datas->phone = $request->phone;

        $datas->address = $request->address;

        $datas->status = $request->status;

        $datas->created_by = Auth::user()->id;

    	$datas->updated_by = Auth::user()->id;

        $findVal = Supplier::where('name' , '=', $request->name)->first();

        if(empty($findVal)) {

            $datas->save();

            return redirect('/supplier/add')->with('message','Inserted Successfully.');

        } else{

            return redirect('/supplier/add')->with('error','Already Exists.');

        }
    }

    public function manage(){

        $listData = DB::table('supplier')->paginate(5);

        return view('admin.Supplier.SupplierList',['listData' => $listData]);

    }
    public function edit($id){

        $editData = Supplier::where('id', $id)->first();

        $publish = PublishName::all();

        return view('admin.Supplier.SupplierAdd',['editData' => $editData, 'publish' => $publish]);

    }

    public function update(Request $request){
       $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        $datas = Supplier::find($request->id);

        $datas->name =  $request->name;

        $datas->email = $request->email;

        $datas->phone = $request->phone;

        $datas->address = $request->address;

        $datas->status = $request->status;

        $datas->updated_by = Auth::user()->id;

        $dataExists = Supplier::where('name', $request->name)->first();

        if(!empty($dataExists) && $request->id != $dataExists->id) {

            return redirect('/supplier/edit/'.$request->id.'')->with('error',''.$request->name.' Has Already Been Taken.');

        }

        if(!empty($datas)) {

            $datas->save();

            return redirect('/supplier/list')->with('message','Updated Successfully.');

        } else{

            return redirect('/supplier/add')->with('error','Not Updated Successfully.');
        }
    }
    public function delete($id){

        $datas = Supplier::find($id);

        $datas->delete();

        Product::where('supplier_id', $id)->update(['supplier_id' => 0]);

        return redirect()->back()->with('message','Deleted Successfully.');
        
    }
    public function publishStatus($status, $id){

        $datas = Supplier::find($id);

        $publish = PublishName::where('name', $status)->first();

        $datas->status = $publish->id;

        $datas->save();

        return redirect()->back()->with('message','Updated Successfully.');
    }
   
    
}
