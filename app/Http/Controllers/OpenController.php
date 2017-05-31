<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Page;
use App\Model\Product;
use App\Model\ProductCategory;
use ChrisKonnertz\OpenGraph\OpenGraph;

class OpenController extends Controller
{
    public function page(Page $page) {
        
        $og = new OpenGraph;
        
        $og->title($page->title)
            ->type('article')
            ->image($page->image)
            ->description($page->description)
            ->url()
            ->locale('sr_RS')
            ->localeAlternate(['en_UK'])
            ->siteName('Cubes')
            ->determiner('the');
        
        if($page->visible == 0){
            abort(404, "Page $page->title not found");
        }
        
        return view('open.page', compact('page', 'og'));
    }
    
    public function contactForm(Page $page) {
        $this->validate(request(), [
            "name" => "required",
            "email" => "required|email",
            "text" => "required"
        ]);
        
        // send email to user with reset link
        Mail::to(request('aleksacvijic@gmail.com'))->send(new PasswordRecovery($token));
        
        return back();
        
    }
    
    public function category(ProductCategory $category){
        
        $og = new OpenGraph;
        
        $og->title($category->name)
            ->type('category')
            ->image($category->image)
            ->description($category->text)
            ->url()
            ->locale('sr_RS')
            ->localeAlternate(['en_UK'])
            ->siteName('Cubes')
            ->determiner('the');

        $requestedProducts = Product::where("category_id", "=", $category->id)->get();
        
        return view('open.category', compact('requestedProducts', 'category', 'og'));
    }
    
    public function product(Product $product){
        
        $og = new OpenGraph;
        
        $og->title($product->name)
            ->type('product')
            ->image($product->image)
            ->description($product->description)
            ->url()
            ->locale('sr_RS')
            ->localeAlternate(['en_UK'])
            ->siteName('Cubes')
            ->determiner('the');
        
        $recentProducts = [];
        if(session()->has('recent_products')) {
            $recentProducts = session('recent_products');
        } 
        
        $recentProducts[$product->id] = $product->name;
        session([
            'recent_products' => $recentProducts
        ]);
        
        $recentProductsForBlade = [];
        foreach ($recentProducts as $key => $value) {
            $recentProductsForBlade[] = Product::where('id', '=', $key)->first();
        }
        
        $allComments = $product->getComments();
        
        return view('open.product', compact('product', 'recentProductsForBlade', 'allComments', 'og'));
    }
    
    public function news() {
        
    }
    
}
