<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MedicineGroup;
use App\Product;
use App\PublishName;
use DB;
use Auth;

class MedicineGroupController extends Controller
{
    public function index(){

        $publish = PublishName::all();

    	return view('admin.MedicineGroups.medicinesGroupAdd',['publish' => $publish]);
    }

    public function save(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|unique:medicine_groups'
        ]);

    	$datas = new MedicineGroup();

        $datas->name = $request->name;

    	$datas->status = $request->status;

        $datas->created_by = Auth::user()->id;

        $datas->updated_by = Auth::user()->id;

        $findGroup = MedicineGroup::where('name' , '=', $request->name)->first();

        if(empty($findGroup)) {

            $datas->save();

            return redirect('/groups/add')->with('message','Inserted Successfully.');

        } else{

            return redirect('/groups/add')->with('error','Already Inserted this Group.');
        }
    }

    public function manage(){

        $datas = DB::table('medicine_groups')->paginate(10);

        return view('admin.MedicineGroups.medicinesGroupManage',['groups' => $datas]);

    }
    public function edit($id){

        $group = MedicineGroup::where('id', $id)->first();

        $publish = PublishName::all();

        return view('admin.MedicineGroups.medicinesGroupAdd',['group' => $group, 'publish' => $publish]);

    }

    public function update(Request $request){

       $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $datas = MedicineGroup::find($request->groupID);

        $datas->name =  $request->name;

        $datas->status = $request->status;

        $datas->updated_by = Auth::user()->id;

        $groupNameExists = MedicineGroup::where('name', $request->name)->first();

        if(!empty($groupNameExists) && $request->groupID != $groupNameExists->id) {

            return redirect('/groups/edit/'.$request->groupID.'')->with('error',''.$request->name.' Has Already Been Taken.');

        }

        if(!empty($datas)) {

            $datas->save();

            return redirect('/groups/list')->with('message','Updated Successfully.');

        } else{

            return redirect('/groups/add')->with('error','Not Updated Successfully.');

        }
    }

    public function delete($id){

        $group = MedicineGroup::find($id);

        $group->delete();

        Product::where('group_id', $id)->update(['group_id' => 0]);

        return redirect()->back()->with('message','Deleted Successfully.');

    }
    
    public function publishStatus($status, $id){

        $datas = MedicineGroup::find($id);

        $publish = PublishName::where('name', $status)->first();

        $datas->status = $publish->id;

        $datas->save();
        
        return redirect()->back()->with('message','Updated Successfully.');
    }
}
