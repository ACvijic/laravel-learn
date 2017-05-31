<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Post;

class PostsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('posts.index');
    }
    
    public function changeStatus(Request $request){
        $data = $request->all();
        
        $post = Post::find($data['id']);
        if($post->status == 1){
            $post->status = 0;
        }else{
            $post->status = 1;
        }
        
        $post->save();
        
    }

    public function dataTable(Request $request) {
        $datatablesSentParams = $request->all();
        
        $draw = '1';
        $page = '1';
        $limit = '10';
        
        $filters = array();
        $order = array();
        
        if(isset($datatablesSentParams['draw'])){
            
            $draw = $datatablesSentParams['draw'];
            if(isset($datatablesSentParams['length'])){
                $limit = $datatablesSentParams['length'];
                
                if(isset($datatablesSentParams['start'])){
                    $page = $datatablesSentParams['start'] / $datatablesSentParams['length'];
                    $page = floor($page);
                }
                
            }
        }
        
        $columns = array(
                'image',
                'title',
                'category',
                'body',
                'options'
            );
        
        if(isset($datatablesSentParams['order']) && is_array($datatablesSentParams['order'])){
            
            foreach($datatablesSentParams['order'] as $columnOrder){
                if(isset($columns[$columnOrder['column']])){
                    $order[$columns[$columnOrder['column']]] = $columnOrder['dir'];
                }
            };
        }
        
        foreach($datatablesSentParams['columns'] as $key => $column){
            if($column['searchable'] == 'true'){
                $filters['like'][$columns[$key]] = $column;
            }
        }
        
        $searchAllValue = $datatablesSentParams['search']['value'];
        $filters['equal']['all'] = $searchAllValue;
        $filters['equal']['show_with_status'] = $datatablesSentParams['show_with_status'];
        $posts = Post::search([
           'filters' =>  $filters,
            'order' => $order,
            'limit' => $limit,
            'page' => $page
        ]);
        $total = Post::countPosts();
        $filteredResults = Post::countPosts($filters);
        
        return view('posts.datatable', compact('total', 'filteredResults', 'posts', 'draw', 'columns'));
    }

}
