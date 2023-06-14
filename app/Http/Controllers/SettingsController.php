<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;
use DB;
use Auth;

class SettingsController extends Controller
{
    public function index(){
        $info = Settings::first();

    	return view('admin.Settings.settings',['info' => $info]);
    }

    public function update(Request $request){
        
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'website' => 'required',
            'address' => 'required',
            'delivery_charge' => 'required',
            'currency_name' => 'required',
            'currency_symbol' => 'required',
            
        ]);

        $datas = new Settings();
        if($request->id > 0){
            $datas = Settings::find($request->id);
        }
    	
    	$datas->name = $request->name;
        $datas->email = $request->email;
        $datas->phone = $request->phone;
        $datas->website = $request->website;
        $datas->address = $request->address;
        $datas->delivery_charge = $request->delivery_charge;
        $datas->currency_name = $request->currency_name;
        $datas->currency_symbol = $request->currency_symbol;
        // logo
        if($request->hasFile('logo')){
            $file = $request->file('logo');
            $filename = time().$file->getClientOriginalName();
            $file->move('uploads/settings/',$filename);
            $datas->logo = $filename;
        }

        if(!empty($datas)) {
            $datas->save();
            return redirect('/settings/')->with('message','Updated Successfully.');
        } else{
            return redirect('/settings/')->with('error','Not Updated Successfully.');
        }
    }
}
