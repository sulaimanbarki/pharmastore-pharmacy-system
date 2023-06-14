<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\PublishName;
use DB;
use Auth;

class CategoryController extends Controller
{
    public function index(){

        $publish = PublishName::all();

    	return view('admin.Category.categoryAdd',['publish' => $publish]);
    }

    public function save(Request $request){


        $validatedData = $request->validate([
            'name' => 'required|unique:categories',
        ]);

    	$categories = new Category();

        $categories->name = $request->name;

    	$categories->status = $request->status;

        $categories->created_by = Auth::user()->id;

        $categories->updated_by = Auth::user()->id;

        $findVal = Category::where('name' , '=', $request->name)->first();

        if(empty($findVal)) {

            $categories->save();    

            return redirect('/category/add')->with('message','Inserted Successfully.');

        } else{

            return redirect('/category/add')->with('error','Already Inserted this Category.');

        }
    }

    public function manage(){

        $categories = DB::table('categories')->paginate(10);

        return view('admin.Category.manageCategory',['category' => $categories]);

    }

    public function edit($id){

        $categories = Category::where('id', $id)->first();

        $publish = PublishName::all();

        return view('admin.Category.categoryAdd',['category' => $categories, 'publish' => $publish]);
    }

    public function update(Request $request){

        $validatedData = $request->validate([
            'name' => 'required',
        ]);

       
        $categories = Category::find($request->catID);

        $categories->name =  $request->name;

        $categories->status = $request->status;

        $categories->updated_by = Auth::user()->id;

        $categoryNameExists = Category::where('name', $request->name)->first();

        if(!empty($categoryNameExists) && $request->catID != $categoryNameExists->id) {

            return redirect('/category/edit/'.$request->catID.'')->with('error',''.$request->name.' Has Already Been Taken.');

        }

        if(!empty($categories)) {

            $imgInfo = $request->file('catImage');

            if(isset($imgInfo)){

                if(file_exists($categories->image)){

                    unlink($categories->image);

                }

                $lastId = $request->catID;

                $imgInfo = $request->file('catImage');

                $imgName = $lastId.$imgInfo->getClientOriginalName();

                $folderName = 'projectImage/category/';

                $imgInfo->move($folderName, $imgName);

                $imgUrl = $folderName.$imgName;

                // update image name
                $categories->image = $imgUrl;

                $categories->save();

            }else{

                $categories->save();

            }

            return redirect('/category/list')->with('message','Updated Successfully.');

        } else{

            return redirect('/category/add')->with('error','Not Updated Successfully.');

        }
    }

    public function delete($id){

        $category = Category::find($id);

        $category->delete();

        if(file_exists($category->image)){

            unlink($category->image);

        }  

        Product::where('category_id', $id)->delete();

        return redirect()->back()->with('message','Deleted Successfully.');
        
    }
    public function publishStatus($status, $id){

        $categories = Category::find($id);

        $publish = PublishName::where('name', $status)->first();

        $categories->status = $publish->id;

        $categories->save();

        return redirect()->back()->with('message','Updated Successfully.');
    }
}
