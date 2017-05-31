<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ProductCategory;
use Intervention\Image\Facades\Image;

class ProductCategoriesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index() {
        $categories = ProductCategory::active()->get();
        
        return view('product-categories.index', compact('categories'));
    }
    
    public function create(Request $request){
        if($request->isMethod('post')){
            $this->validate($request, [
                'name' => 'required|max:191',
                'text' => 'required',
                'image' => 'file|mimes:jpeg,bmp,png'
            ]);
            $category = new ProductCategory();
            $category->name = $request->input('name');
            $category->text = $request->input('text');
            
            $image = "";
            // check if the image (file) is uploaded
            if ($request->hasFile('image')) {
                $directory = config('filesystems.product-categories-uploads-path');
                $fileName = str_slug($request->input('name'), '-') . "." . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path($directory), $fileName);
                $image =  $directory . $fileName;
                
                // resize image
                $img = Image::make(public_path($directory) . $fileName);
                $img->resize(817, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path($directory) . str_slug($request->input('name'), '-') . "-xl." . $request->file('image')->getClientOriginalExtension(), 100);

                $img->resize(450, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path($directory) . str_slug($request->input('name'), '-') . "-l." . $request->file('image')->getClientOriginalExtension(), 100);

                $img->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path($directory) . str_slug($request->input('name'), '-') . "-m." . $request->file('image')->getClientOriginalExtension(), 100);

                $img->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path($directory) . str_slug($request->input('name'), '-') . "-s." . $request->file('image')->getClientOriginalExtension(), 100);

            }
            
            
            $category->image = $image;
            $category->save();
            
            // set message to other page
            session()->flash('message', [
                'status' => 'success',
                'text' => "Product category: $category->name was created successfully"
            ]);
            
            return redirect()->route('product-categories-list');
        }
        return view('product-categories.create');
    }
    
    public function edit(Request $request, ProductCategory $category) {
        if($request->isMethod('post')){
            $this->validate($request, [
                'name' => 'required|max:191',
                'text' => 'required',
                'image' => 'file|mimes:jpeg,bmp,png'
            ]);
            $category->name = $request->input('name');
            $category->text = $request->input('text');
            
            $image = $category->image;
            // check if the image (file) is uploaded
            if ($request->hasFile('image')) {
                $directory = config('filesystems.product-categories-uploads-path');
                $fileName = str_slug($request->input('name'), '-') . "." . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path($directory), $fileName);
                $image =  $directory . $fileName;
                
                // resize image
                $img = Image::make(public_path($directory) . $fileName);
                $img->resize(817, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path($directory) . str_slug($request->input('name'), '-') . "-xl." . $request->file('image')->getClientOriginalExtension(), 100);

                $img->resize(450, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path($directory) . str_slug($request->input('name'), '-') . "-l." . $request->file('image')->getClientOriginalExtension(), 100);

                $img->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path($directory) . str_slug($request->input('name'), '-') . "-m." . $request->file('image')->getClientOriginalExtension(), 100);

                $img->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path($directory) . str_slug($request->input('name'), '-') . "-s." . $request->file('image')->getClientOriginalExtension(), 100);

            }
            
            
            $category->image = $image;
            $category->save();
            
            // set message to other page
            session()->flash('message', [
                'status' => 'success',
                'text' => "Product category: $category->name was successfully edited!"
            ]);
            
            return redirect()->route('product-categories-list');
        }
        
        return view('product-categories.edit', compact('category'));
    }
    
    public function delete(ProductCategory $category){
        $category->deleted = 1;
        $category->save();
        
        // set message to other page
        session()->flash('message', [
            'status' => 'success',
            'text' => "Product category: $category->name was deleted successfully"
        ]);

        return redirect()->route('product-categories-list');
    }
    
    public function deleteImage(ProductCategory $category){
        $category->image = "";
        $category->save();
        
        // set message to other page
        session()->flash('message', [
            'status' => 'success',
            'text' => "Image for product category: $category->name was deleted successfully"
        ]);

        return redirect()->route('product-categories-list');
    }
    
    public function changeStatus(ProductCategory $category){
       
        if($category->visible == 1){
            $category->visible = 0;
            
            // set message to other page
            session()->flash('message', [
                'status' => 'success',
                'text' => "Product category: $category->name was hidden successfully"
            ]);
        }else{
            $category->visible = 1;
            
            // set message to other page
            session()->flash('message', [
                'status' => 'success',
                'text' => "Product category: $category->name was activated successfully"
            ]);
        }
        
        $category->save();
        

        return redirect()->route('product-categories-list');
    }
    
}
