<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Comment;
use App\Model\Product;
class CommentsController extends Controller
{
    public function create() {
        
        // comments not deleted and active
        $validComments = Comment::active()->get();
        
        // comments not banned and active
        $validProducts = Product::active()->visible()->get();

        $commentsPossibleValues = "0";
        if (count($validComments) > 0) {
            foreach ($validComments as $value) {
                $commentsPossibleValues .= "," . $value->id;
            }
        }
        
        $productsPossibleValues = "";
        if (count($validProducts) > 0) {
            foreach ($validProducts as $value) {
                $productsPossibleValues .= "," . $value->id;
            }
        }

        if (request()->isMethod('post')) {
            $this->validate(request(), [
                'name' => 'max:191',
                'email' => "required|email",
                'title' => 'required|max:191',
                'text' => 'required|max:600',
                'product_id' => "required|integer|in:$productsPossibleValues",
                'comment_id' => "required|integer|in:$commentsPossibleValues",
            ]);

            $comment = new Comment();
            $comment->name = request('name');
            $comment->email = request('email');
            $comment->title = request('title');
            $comment->text = request('text');
            $comment->product_id = request('product_id');
            $comment->comment_id = request('comment_id');

            $comment->save();

            // set message to other page
            session()->flash('message', [
                'status' => 'success',
                'text' => "Your comment with the title:: $comment->title has been noted and is pending activation"
            ]);

            return back();
        }
    }
    
    public function index() {
        $comments = Comment::all();
        
        return view('comments.index', compact('comments'));
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
                'product_or_comment',
                'name',
                'email',
                'title',
                'text',
                'number_of_likes',
                'reported',
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
        $comments = Comment::search([
           'filters' =>  $filters,
            'order' => $order,
            'limit' => $limit,
            'page' => $page
        ]);
        $total = Comment::countComments();
        $filteredResults = Comment::countComments($filters);
        
        return view('comments.datatable', compact('total', 'filteredResults', 'comments', 'draw', 'columns'));
    }
}
