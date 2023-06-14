<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Orders;
use App\Rules\CheckPassowrd;
use App\User;
use App\WishList;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function myaccount(){

        $orders= Orders::where('customer_id',Auth::id())->orderBy('order_id', 'desc')->get();

        $wishlists= WishList::where(['user_id'=>Auth::id(),'is_delete'=>0])->get();

        $categories= Category::Where('status',1)->get();
        
        return view('frontend.my_account', compact('orders','wishlists','categories'));

    }

    public function update_account_details(Request $request){
        
        $request->validate([
            'firstname' => 'required',
            'lastname'  => 'required',
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email,'.Auth::id(),
            'current_password'      => ['nullable','min:6', new CheckPassowrd],
            'password'      => 'confirmed|required_with:current_password'
        ]);
        
        $userid= Auth::id();

        $user = User::find($userid);

        $user->firstname    = $request->firstname;

        $user->lastname     = $request->lastname;

        $user->name         = $request->name;

        $user->email        = $request->email;

        $user->password     = bcrypt($request->password);

        try{
            $user->save();

            session()->flash('message','Account Details updated');

            session()->flash('type','success');

            return redirect()->route('myaccount');

        }catch(Exception $e){

            session()->flash('message',$e->getMassage());

            session()->flash('type','danger');

            return redirect()->back();
        }
    }

    public function update_address(Request $request){
        $request->validate([
            'country'       => 'required',
            'address'       => 'required',
            'city'          => 'required',
            'postcode'      => 'required'
        ]);

        $userid= Auth::id();

        $user = User::find($userid);

        $user->address  = $request->address;

        $user->country  = $request->country;

        $user->city     = $request->city;

        $user->postcode = $request->postcode;
        
        try{
            $user->save();

            session()->flash('message','Address updated');

            session()->flash('type','success');

            return redirect()->route('myaccount');

        }catch(Exception $e){

            session()->flash('message',$e->getMassage());

            session()->flash('type','danger');

            return redirect()->back();
        }

        
    }

    public function add_wishlist($id){

        if($id){

            $userId= Auth::id();

            $hasData= WishList::Where(['user_id'=> $userId, 'product_id'=> $id])->count();

            if($hasData==0){

                $wishlist= new WishList();

                $wishlist->user_id  = $userId;

                $wishlist->product_id= $id;

                $wishlist->is_delete=0;
                
                try{

                    $wishlist->save();

                    session()->flash('message','Item added to your wishlist');

                    session()->flash('type','success');

                    session()->flash('page','wishlist');
    
                    return redirect()->route('myaccount');

                }catch(Exception $e){

                    session()->flash('message',$e->getMassage());

                    session()->flash('type','danger');

                    session()->flash('page','wishlist');
    
                    return redirect()->route('myaccount');

                }

            }else{

                session()->flash('message','This item already added to your wishlist!');

                session()->flash('type','danger');

                session()->flash('page','wishlist');

                return redirect()->route('myaccount');
            }
        }        
    }

    public function remove_wishlist($id){
      
      $wishlist= WishList::find($id);

      $wishlist->is_delete=1;

      try{
          $wishlist->save();

          session()->flash('message','Item removed from wishlist.');

          session()->flash('type','success');

          return redirect()->route('myaccount');

      }catch(Exception $e){

        session()->flash('message', $e->getMessage());

        session()->flash('type','danger');

        return redirect()->route('myaccount');
        
      }
    }


}
