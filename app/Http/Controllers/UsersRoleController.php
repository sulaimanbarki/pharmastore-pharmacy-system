<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UsersRole;
use App\PublishName;
use DB;

class UsersRoleController extends Controller
{
    public function index(){

    	$listData = DB::table('users_roles')->paginate(5);

        $publish = PublishName::all();

    	return view('admin.UserRoles.roles',['listData' => $listData, 'publish' => $publish]);
    }

    public function save(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|unique:users_roles',
            'slug' => 'required|unique:users_roles',
        ]);

    	$datas = new UsersRole();

        $datas->name = $request->name;

        $datas->slug = $request->slug;

        $findVal = UsersRole::where('name' , '=', $request->name)->first();

        if(empty($findVal)){    

            $datas->save();

            return redirect('/useroles/')->with('message','Inserted Successfully.');

        } else{

            return redirect('/useroles/')->with('error','Already Exists.');

        }
    }

    public function edit($id){

    	$listData = DB::table('users_roles')->paginate(5);

        $editData = UsersRole::where('id', $id)->first();

        $publish = PublishName::all();

        return view('admin.UserRoles.roles',['editData' => $editData, 'listData' => $listData, 'publish' => $publish]);

    }

    public function update(Request $request){

       $validatedData = $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        $datas = UsersRole::find($request->id);

        $datas->name =  $request->name;

        $datas->slug =  $request->slug;

        $dataExists = UsersRole::where('name', $request->name)->first();

        if(!empty($dataExists) && $request->id != $dataExists->id) {

            return redirect('/useroles/edit/'.$request->id.'')->with('error',''.$request->name.' Has Already Been Taken.');

        }

        if(!empty($datas)) {

            $datas->save();

            return redirect('/useroles/')->with('message','Updated Successfully.');

        } else{

            return redirect('/useroles/')->with('error','Not Updated Successfully.');

        }
    }

    public function delete($id){

        $datas = UsersRole::find($id);

        $datas->delete();
        
        return redirect('/useroles/')->with('message','Deleted Successfully.');
    }
}
