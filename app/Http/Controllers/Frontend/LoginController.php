<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(){

        $categories= Category::Where('status',1)->get();

        return view('frontend.signin',compact('categories'));

    }

    public function showRegistrationForm(){

        $categories= Category::Where('status',1)->get();

        return view('frontend.signup',compact('categories'));

    }

    public function registerProcess(Request $request){

        $request->validate([
            'firstname'     => 'required',
            'lastname'      => 'required',
            'phone'         => 'required|min:11|unique:users,phone',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|confirmed|min:6'
        ]);

        $user = new User;

        $user->name         = $request->firstname.' '.$request->lastname;

        $user->firstname    = $request->firstname;

        $user->lastname     = $request->lastname;

        $user->email        = $request->email;

        $user->phone        = $request->phone;

        $user->password     = bcrypt($request->password);

        $user->users_role_id= 4;

        $user->isAdmin      = 0;

        $user->status       = 1;
        
        try{

            $user->save();

            session()->flash('message','Registration successfully completed!');

            session()->flash('type','success');

            $credentials=['email'=>$request->email,'password'=>$request->password];

            if(Auth::attempt($credentials)){
                return redirect()->route('myaccount');
            }
            // return redirect()->route('customer.signin');
        }catch(Exception $e){

            session()->flash('message',$e->getMassage());

            session()->flash('type','danger');

            return redirect()->back();

        }
    }

    public function login(Request $request){
        
        $request->validate([
            'email'         => 'required|email',
            'password'      => 'required'
        ]);

        $credentials=$request->except(['_token','checkout_login']);

        if(Auth::attempt($credentials)){

            if($request->checkout_login || session('is_checkout')==1){

                session()->forget('is_checkout');

                return redirect('/checkout');

            }else{

                return redirect('/my-account');

            }
            
        }

        session()->flash('message','Invalid Credentials!');

        session()->flash('type','danger');
        
        return redirect()->back();

    }
}
