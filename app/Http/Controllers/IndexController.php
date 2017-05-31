<?php

namespace App\Http\Controllers;
use App\Model\ProductCategory;
use Illuminate\Http\Request;
use ChrisKonnertz\OpenGraph\OpenGraph;

class IndexController extends Controller
{
    public function index(){
        $og = new OpenGraph;
        
        $og->title('laravel')
            ->type('website')
            ->url()
            ->locale('sr_RS')
            ->localeAlternate(['en_UK'])
            ->siteName('Cubes')
            ->determiner('the');
        
        return view('index.index', compact('og'));
    }
}
