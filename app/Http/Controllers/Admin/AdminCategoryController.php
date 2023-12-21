<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use File;

class AdminCategoryController extends Controller
{
    public function index(){
        $categories = Category::latest('id')->with('parent_category')->paginate(5);
        return view('admin.category.index',compact('categories'));
    }

    public function create(){
        return view('admin.category.create');
    }

    public function store(Request $request){
        $request->validate([
            "name"=>['required'],
            "image"=>['required','mimes:png,jpg,jpeg']
        ]);
        // store image
        // $file = $request->file('image');
        // $file_name = uniqid().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('assets/image/categories'),$file_name);

        $category=Category::create([
            'name'=>$request->name,
            "slug"=>Str::slug($request->name),
        ]);
        return redirect()->route('admin.category')->with('success',$category->name." is created.");
    }

    public function edit(Category $category){
        return view('admin.category.edit',compact('category'));
    }

    public function update(Request $request,Category $category){
        $request->validate([
            'name'=>['required','unique:users,categories'],
        ]);

        // check request has image or not 
        // if(!$request->file('image')){
        //     $file_name = $category->image;
        // }else{
            // delete old image
            // File::delete(public_path("assets/image/categories/$category->image"));
            // store new image
        //     $file = $request->file('image');
        //     $file_name = uniqid().'.'.$file->getClientOriginalExtension();
        //     $file->move(public_path('assets/image/categories/'),$file_name);
        // }

        $category->update([
            'name'=>$request->name,
            'slug'=>Str::slug($request->name),
        ]);
        return redirect()->route('admin.category')->with('success',"Successfully Updated.");
    }

    public function destroy(Category $category){
        //delete image
        // if($category->image){
        //     File::delete(public_path("assets/image/categories/$category->image"));
        // }
        $category->delete();
        return redirect()->route('admin.category')->with('success','Successfully Deleted.');
    }

    public function getChildCategories(Request $request){
        $parentCategoryId = $request->parent_category_id;
        $categories = Category::where('parent_category_id',$parentCategoryId)->get();
        return $categories;
    }
}
