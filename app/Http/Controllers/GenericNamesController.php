<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GenericNames;
use App\Product;
use App\PublishName;
use DB;
use Auth;

class GenericNamesController extends Controller
{
     public function index(){

        $publish = PublishName::all();

    	return view('admin.GenericNames.genericNameAdd',['publish' => $publish]);
    }

    public function save(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|unique:generic_names',
        ]);

    	$datas = new GenericNames();

        $datas->name = $request->name;

    	$datas->status = $request->status;

        $datas->created_by = Auth::user()->id;

        $datas->updated_by = Auth::user()->id;

        $findVal = GenericNames::where('name' , '=', $request->name)->first();

        if(empty($findVal)) {

            $datas->save();

            return redirect('/genericnames/add')->with('message','Inserted Successfully.');

        } else{

            return redirect('/genericnames/add')->with('error','Already Exists.');

        }
    }

    public function manage(){

        $listData = DB::table('generic_names')->paginate(5);

        return view('admin.GenericNames.genericNameManage',['listData' => $listData]);

    }

    public function edit($id){

        $editData = GenericNames::where('id', $id)->first();

        $publish = PublishName::all();

        return view('admin.GenericNames.genericNameAdd',['editData' => $editData, 'publish' => $publish]);

    }

    public function update(Request $request){

       $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $datas = GenericNames::find($request->id);

        $datas->name =  $request->name;

        $datas->status = $request->status;

        $datas->updated_by = Auth::user()->id;

        $dataExists = GenericNames::where('name', $request->name)->first();

        if(!empty($dataExists) && $request->id != $dataExists->id) {

            return redirect('/genericnames/edit/'.$request->id.'')->with('error',''.$request->name.' Has Already Been Taken.');

        }

        if(!empty($datas)) {

            $datas->save();

            return redirect('/genericnames/list')->with('message','Updated Successfully.');

        } else{
            return redirect('/genericnames/add')->with('error','Not Updated Successfully.');

        }
    }

    public function delete($id){

        $datas = GenericNames::find($id);

        $datas->delete();

        Product::where('generic_id', $id)->update(['generic_id' => 0]);

        return redirect()->back()->with('message','Deleted Successfully.');

    }
    
    public function publishStatus($status, $id){

        $datas = GenericNames::find($id);

        $publish = PublishName::where('name', $status)->first();

        $datas->status = $publish->id;

        $datas->save();
        
        return redirect()->back()->with('message','Updated Successfully.');
    }
}
