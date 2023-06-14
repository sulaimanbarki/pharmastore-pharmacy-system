<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function contact(){

        $categories= Category::Where('status',1)->get();

        return view('frontend.contact',compact('categories'));

    }

    public function contact_form_submit(Request $request){ 

        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email',
            'phone'     => 'required|min:11',
            'message'   => 'required',
        ]);

        $data['name']   = $request->name;

        $data['email']  = $request->email;

        $data['phone']  = $request->phone;

        $data['message']= $request->message;

        mail::to('sumona.uiu@gmail.com')->send(new ContactMail($data));
        
        session()->flash('message','Thank you for messaging us, we will get back to you soon.');

        session()->flash('type','success');

        return redirect()->route('contact_submit');
        
    }
}
