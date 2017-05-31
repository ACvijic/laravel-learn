<?php

namespace App\Http\Controllers;

use App\Model\Product;
use App\Model\ProductCategory;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductsController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index() {
        $products=  Product::active()->get();
        
        return view('products.index', compact('products'));
    }
    
    public function create(Request $request) {
        $categoriesActive=  ProductCategory::active()->get();
        
        $categoriesPossibleValues = "";
        if (count($categoriesActive) > 0) {
            foreach ($categoriesActive as $value) {
                $categoriesPossibleValues .= "," . $value->id;
            }
        }
        if($request->isMethod('post')){
            $this->validate($request, [
                'name' => 'required|max:191',
                'category_id' => "required|in:$categoriesPossibleValues",
                'text' => 'required',
                'image' => 'file|mimes:jpeg,bmp,png',
                'price' => 'required|numeric',
                'discount' => 'required|numeric|max:80'
            ]);
            $product = new Product();
            $product->name = $request->input('name');
            $product->category_id = $request->input('category_id');
            $product->description = $request->input('description');
            $product->text = $request->input('text');
            $product->price = $request->input('price');
            $product->discount = $request->input('discount');
            
            $image = "";
            // check image (file ) is uploaded
            if ($request->hasFile('image')) {
                $directory = config('filesystems.products-uploads-path');
                //$fileName = $request->file('image')->getClientOriginalName();
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
            
            
            $product->image = $image;
            $product->save();
            
            // set message to other page
            session()->flash('message', [
                'status' => 'success',
                'text' => "Product: $product->name was created successfully"
            ]);
            
            return redirect()->route('products-list');
        }
        
        return view('products.create', compact('categoriesActive'));
    }
    
    public function edit(Request $request, Product $product) {
        $categoriesActive=  ProductCategory::active()->get();
        
        $categoriesPossibleValues = "";
        if (count($categoriesActive) > 0) {
            foreach ($categoriesActive as $value) {
                $categoriesPossibleValues .= "," . $value->id;
            }
        }
        if($request->isMethod('post')){
            $this->validate($request, [
                'name' => 'required|max:191',
                'category_id' => "required|in:$categoriesPossibleValues",
                'text' => 'required',
                'image' => 'file|mimes:jpeg,bmp,png',
                'price' => 'required|numeric',
                'discount' => 'required|numeric|max:80'
            ]);
            $product->name = $request->input('name');
            $product->category_id = $request->input('category_id');
            $product->description = $request->input('description');
            $product->text = $request->input('text');
            $product->price = $request->input('price');
            $product->discount = $request->input('discount');
            
            $image = $product->image;
            // check image (file ) is uploaded
            if ($request->hasFile('image')) {
                $directory = config('filesystems.products-uploads-path');
                //$fileName = $request->file('image')->getClientOriginalName();
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
            
            
            $product->image = $image;
            $product->save();
            
            // set message to other page
            session()->flash('message', [
                'status' => 'success',
                'text' => "Product: $product->name was edited successfully"
            ]);
            
            return redirect()->route('products-list');
        }
        
        return view('products.edit', compact('product', 'categoriesActive'));
    }
    
    public function deleteImage(Product $product){
        $product->image = "";
        $product->save();
        
        // set message to other page
        session()->flash('message', [
            'status' => 'success',
            'text' => "Image for product: $product->name was deleted successfully"
        ]);

        return redirect()->route('products-list');
    }
    
    public function delete(Product $product){
        $product->deleted = 1;
        $product->save();
        
        // set message to other page
        session()->flash('message', [
            'status' => 'success',
            'text' => "The product: $product->name was deleted successfully"
        ]);

        return redirect()->route('products-list');
    }
    
    public function changeStatus(Product $product){
       
        if($product->visible == 1){
            $product->visible = 0;
            
            // set message to other page
            session()->flash('message', [
                'status' => 'success',
                'text' => "The product: $product->name was hidden successfully"
            ]);
        }else{
            $product->visible = 1;
            
            // set message to other page
            session()->flash('message', [
                'status' => 'success',
                'text' => "The product: $product->name was activated successfully"
            ]);
        }
        
        $product->save();
        

        return redirect()->route('products-list');
    }
}
