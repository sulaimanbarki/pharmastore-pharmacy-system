<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\UsersRole;
use App\PublishName;
use DB;
use Auth;

class UserController extends Controller
{
     public function index(){

     	$roles = new UsersRole();

        if(Auth::user()->user_role->slug == "superadmin"){

               $roles  = UsersRole::all();

        }elseif (Auth::user()->user_role->slug == "admin") {

            $roles  = UsersRole::where('slug','=','stuff')->orWhere('slug','=','customer')->get();

        }else{

            $roles  = UsersRole::where('slug','=','customer')->get();

        }

        $publish = PublishName::all();

    	return view('admin.Users.userAdd',['roles' => $roles, 'publish' => $publish]);
    }

    public function save(Request $request){

        $validatedData = $request->validate([
            'role' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6',
            'phone' => 'required|min:11|digits_between: 11,13',
            'status' => 'required'
        ]);

    	$datas = new User();

        $datas->users_role_id = $request->role;

        $datas->isAdmin = isset($request->isAdmin) ? $request->isAdmin: 0;

    	$datas->firstname = $request->firstname;

    	$datas->lastname = $request->lastname;

    	$datas->email = $request->email;

    	$datas->password = Hash::make($request->password);

    	$datas->phone = $request->phone;

    	$datas->dob = $request->dob;

        $datas->address = $request->address;

        $datas->postcode = $request->postcode;

        $datas->city = $request->city;

    	$datas->country = $request->country;

        $datas->status = $request->status;

    	$datas->created_by = Auth::user()->id;

    	$datas->image = 'image';

        $findVal = User::where('email' , '=', $request->email)->first();

        if(empty($findVal)) {

            $datas->save();

            $imgInfo = $request->file('image');

            if(isset($imgInfo)){

                $lastId = $datas->id;

                $imgInfo = $imgInfo;

                $imgName = $lastId.$imgInfo->getClientOriginalName();

                $folderName = 'projectImage/users/';

                $imgInfo->move($folderName, $imgName);

                $imgUrl = $folderName.$imgName;

                // update image name
                $medImg = User::find($lastId);

                $medImg->image = $imgUrl;

                $medImg->save();

            }

            return redirect('/users/add')->with('message','Inserted Successfully.');

        } else{

            return redirect('/users/add')->with('error','Already Exists.');

        }
    }

    

    public function update(Request $request){

       $validatedData = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
        ]);

    	$datas = User::find($request->id);

        $datas->isAdmin = Auth::user()->users_role_id == 1 ? (isset($request->isAdmin) ? $request->isAdmin: 0) : $datas->isAdmin;

    	$datas->firstname = $request->firstname;

    	$datas->lastname = $request->lastname;

    	$datas->phone = $request->phone;

    	$datas->dob = $request->dob;

    	$datas->address = $request->address;

        $datas->postcode = $request->postcode;

        $datas->city = $request->city;

        $datas->country = $request->country;

        $datas->updated_by = Auth::user()->id;

    	$datas->status = isset($request->status) ? $request->status : $datas->status;

        $dataExists = User::where('id', $request->id)->first();

        if(!empty($dataExists) && $request->id != $dataExists->id) {

            return redirect('/users/edit/'.$request->id.'')->with('error',''.$request->name.' Has Already Been Taken.');

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

                $folderName = 'projectImage/users/';

                $imgInfo->move($folderName, $imgName);

                $imgUrl = $folderName.$imgName;

                // update image name
                $medImg = User::find($lastId);

                $medImg->image = $imgUrl;

                $medImg->save();
            }

            return redirect('/users/list')->with('message','Updated Successfully.');

        } else{

            return redirect('/users/add')->with('error','Not Updated Successfully.');
        }
    }

    public function delete($id){

        $datas = User::find($id);

        $datas->delete();

        return redirect()->back()->with('message','Deleted Successfully.');

    }

    public function activeStatus($status, $id){

        $datas = User::find($id);

        $publish = PublishName::where('name', $status)->first();

        $datas->status = $publish->id;

        $datas->save();

        return redirect()->back()->with('message','Updated Successfully.');

    }

    public function details($id){

        $data = User::where('id', $id)->first();

        $role = UsersRole::where('id', $data->users_role_id)->first();

        return view('admin.Users.userDetails',['data' => $data, 'role' => $role]);

    }

    public function reset(){

        return view('admin.Users.passwordReset');

    }

    public function resetpassword(Request $request){
    	
       $validatedData = $request->validate([
            'newpassword' => 'required|min:6',
            'password' => 'required|min:6'
        ]);


       if ($request->newpassword != $request->password) {

       		return redirect('/users/reset')->with('error','Password not matched. Please try again.');

       }else{

       		$user_id = Auth::user()->id;

       		$datas = User::find($user_id);

        	$datas->password = Hash::make($request->password);

        	$datas->save();

            return redirect('/users/reset')->with('message','Reset Password Successfully.');

       }
    }

    public function manage(){

        $listData = DB::table('users')->paginate(5);

        foreach ($listData as $key => $value) {

            if(isset($value->users_role_id)){

                $role = UsersRole::where('id', $value->users_role_id)->first();

                if(isset($role->name)){

                    $listData[$key]->roleName = $role->name;

                }else{

                   $listData[$key]->roleName = "No Role"; 

                }
                
            }
            
        }

        return view('admin.Users.usersManage',['listData' => $listData]);

    }

    public function edit($id){

        $editData = User::where('id', $id)->first();

        $roles = new UsersRole();

        $publish = PublishName::all();

        if(Auth::user()->user_role->slug == "superadmin"){

            $roles  = UsersRole::all();

        }elseif (Auth::user()->user_role->slug == "admin") {

            $roles  = UsersRole::where('slug','=','stuff')->orWhere('slug','=','customer')->get();

        }else{

            $roles  = UsersRole::where('slug','=','customer')->get();

        }

        return view('admin.Users.userAdd',['editData' => $editData, 'roles' => $roles, 'publish' => $publish]);
    }


    public function profile(){

    	$id = Auth::user()->id;

        $data = User::where('id', $id)->first();

        $role = UsersRole::where('id', $data->users_role_id)->first();

        return view('admin.Users.userDetails',['data' => $data, 'role' => $role, 'editprofile' => 1]);

    }  

    public function editProfile(){

    	$id = Auth::user()->id;

        $editData = User::where('id', $id)->first();

     	$roles = UsersRole::all();

        $publish = PublishName::all();

        return view('admin.Users.userAdd',['editData' => $editData, 'roles' => $roles, 'publish' => $publish, 'editprofile' => 1]);

    }

    public function getUser($id){
        
        return $data = User::where('id', $id)->first();
        
    }  
}
