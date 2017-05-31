<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Language;
use App\Model\News;
use App\Model\NewsContent;
use Carbon\Carbon;

class NewsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index($langId) {
        $language = Language::find($langId);
        $defaultLanguage = Language::orderBy('priority', 'asc')->first();
        $defaultLanguageId = Language::orderBy('priority', 'asc')->first()->id;
        $otherLanguages = Language::where('id', '!=', $defaultLanguage->id)->get();

        return view('news.index', compact('langId', 'defaultLanguage', 'otherLanguages', 'defaultLanguageId'));
    }
    
    public function dataTable(Request $request) {
        // get all params sent by dataTable
        $datatablesSentParams = $request->all();
        
        //set defaullt params
        $draw = '1';
        $page = '1';
        $limit = '10';
        
        $filters = array();
        $order = array();
        
        // check if draw has sent a request
        if(isset($datatablesSentParams['draw'])){
            
            // set our default param to the recent draw
            $draw = $datatablesSentParams['draw'];
            if(isset($datatablesSentParams['length'])){
                // length is actually the limit of the number of rows from db
                $limit = $datatablesSentParams['length'];
                
                // start from row?
                if(isset($datatablesSentParams['start'])){
                    // which rows?
                    $page = $datatablesSentParams['start'] / $datatablesSentParams['length'];
                    $page = floor($page);
                }
                
            }
        }
        
        // set columns that are in table, different for each controller
        $columns = array(
                'image',
                'title',
                'text',
                'options'
            );
        
        // order has two params to look at: the column and the direction to order it in
        if(isset($datatablesSentParams['order']) && is_array($datatablesSentParams['order'])){
            
            foreach($datatablesSentParams['order'] as $columnOrder){
                if(isset($columns[$columnOrder['column']])){
                    $order[$columns[$columnOrder['column']]] = $columnOrder['dir'];
                }
            };
        }
        
        // if the column is searchable add it to the list of columns under ['like']['name-o-the-column']
        // like key holds columns with text in them
        foreach($datatablesSentParams['columns'] as $key => $column){
            if($column['searchable'] == 'true'){
                $filters['like'][$columns[$key]] = $column;
            }
        }
        
        // get the value of the search field that looks at the entire table
        $searchAllValue = $datatablesSentParams['search']['value'];
        $lang = $datatablesSentParams['langId'];
        $filters['equal']['all'] = $searchAllValue;
        
        // store search results in a var that has meaning in the context
        $news = NewsContent::search([
           'filters' =>  $filters,
            'order' => $order,
            'limit' => $limit,
            'page' => $page,
            'lang' => $lang
        ]);
        
        // number of all rows in db
        $total = NewsContent::countPosts($lang);
        
        // number of rows gotten after filtering ( i.e. searching, it's practically the same)
        $filteredResults = NewsContent::countPosts($filters, $lang);
        
        return view('news.datatable', compact('total', 'filteredResults', 'news', 'draw', 'columns'));
        
    }

    public function create(Request $request) {
        $defaultLanguage = Language::defaultLang();
        
        $otherLanguages = Language::where('id', '!=', $defaultLanguage->id)->get();

        if ($request->isMethod('post')) {

            $this->validate($request, [
                'title' => 'required|max:191',
                'text' => 'required|max:191',
                'seo_title' => 'required|max:191',
                'seo_description' => 'max:255',
                'seo_keywords' => 'max:255',
                'publish_date' => 'date',
                'image' => 'file|mimes:jpeg,bmp,png',
                'action' => 'required|in:edit,addAnother,goToList',
            ]);
            $article = new News();
            $article->save();
            
            $newsArticle = new NewsContent();
            $newsArticle->title = $request->input('title');
            $newsArticle->description = $request->input('description');
            $newsArticle->text = $request->input('text');
            $newsArticle->seo_title = $request->input('seo_title');
            $newsArticle->seo_description = $request->input('seo_description');
            $newsArticle->seo_keywords = $request->input('seo_keywords');
            $newsArticle->language_id = $defaultLanguage->id;
            $newsArticle->news_id = $article->id;
            $newsArticle->publish_date = Carbon::parse($request->input('publish_date'));

            $image = "";
            // check image (file ) is uploaded
            if ($request->hasFile('image')) {
                $directory = config('filesystems.news-uploads-path');
                //$fileName = $request->file('image')->getClientOriginalName();
                $fileName = str_slug($request->input('title'), '-') . "." . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path($directory), $fileName);
                $image = $directory . $fileName;

                // resize image
                $img = Image::make(public_path($directory) . $fileName);
                $img->resize(817, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path($directory) . str_slug($request->input('title'), '-') . "-xl." . $request->file('image')->getClientOriginalExtension(), 100);

                $img->resize(450, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path($directory) . str_slug($request->input('title'), '-') . "-l." . $request->file('image')->getClientOriginalExtension(), 100);

                $img->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path($directory) . str_slug($request->input('title'), '-') . "-m." . $request->file('image')->getClientOriginalExtension(), 100);

                $img->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path($directory) . str_slug($request->input('title'), '-') . "-s." . $request->file('image')->getClientOriginalExtension(), 100);
            }


            $newsArticle->image = $image;
            $newsArticle->save();
            // set message
            session()->flash('message', [
                'status' => 'success',
                'text' => "News article: $newsArticle->title was created successfully"
            ]);

            $action = $request->input('action');

            $nextLanguage = Language::orderBy('priority', 'asc')->skip(1)->first()->id;
            switch ($action) {
                case 'edit':
                    return redirect()->route('news-edit', [$article->id, $nextLanguage]);
                    break;
                case 'addAnother':
                    return redirect()->route('news-create');
                    break;
                case 'goToList':
                    return redirect()->route('news-list', $defaultLanguage->id);
                    break;
            }
        }
        return view('news.create', compact('otherLanguages'));
    }

    public function edit(Request $request, News $article, Language $lang) {

        $defaultLanguage = Language::orderBy('priority', 'asc')->first();
        $otherLanguages = Language::where('id', '!=', $defaultLanguage->id)->get();
        $value = $article->content->where('language_id', '=', $lang->id)->first();
        $createContentValue = $article->content->where('language_id', '=', $defaultLanguage->id)->first();

        if ($request->isMethod('post')) {

            $this->validate($request, [
                'title' => 'required|max:191',
                'text' => 'required|max:191',
                'seo_title' => 'required|max:191',
                'seo_description' => 'max:255',
                'seo_keywords' => 'max:255',
                'publish_date' => 'date',
                'image' => 'file|mimes:jpeg,bmp,png',
                'action' => 'required|in:edit,addAnother,goToList',
            ]);

            $newsArticle->title = $request->input('title');
            $newsArticle->description = $request->input('description');
            $newsArticle->text = $request->input('text');
            $newsArticle->seo_title = $request->input('seo_title');
            $newsArticle->seo_description = $request->input('seo_description');
            $newsArticle->seo_keywords = $request->input('seo_keywords');
            $newsArticle->language_id = $lang->id;
            $newsArticle->news_id = $article->id;
            $newsArticle->publish_date = Carbon::parse($request->input('publish_date'));

            $image = "";
            // check image (file ) is uploaded
            if ($request->hasFile('image')) {
                $directory = config('filesystems.news-uploads-path');
                //$fileName = $request->file('image')->getClientOriginalName();
                $fileName = str_slug($request->input('title'), '-') . "." . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path($directory), $fileName);
                $image = $directory . $fileName;

                // resize image
                $img = Image::make(public_path($directory) . $fileName);
                $img->resize(817, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path($directory) . str_slug($request->input('title'), '-') . "-xl." . $request->file('image')->getClientOriginalExtension(), 100);

                $img->resize(450, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path($directory) . str_slug($request->input('title'), '-') . "-l." . $request->file('image')->getClientOriginalExtension(), 100);

                $img->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path($directory) . str_slug($request->input('title'), '-') . "-m." . $request->file('image')->getClientOriginalExtension(), 100);

                $img->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path($directory) . str_slug($request->input('title'), '-') . "-s." . $request->file('image')->getClientOriginalExtension(), 100);
            }


            $newsArticle->image = $image;
            $newsArticle->save();
            // set message
            session()->flash('message', [
                'status' => 'success',
                'text' => "News article: $newsArticle->title was edited successfully"
            ]);

            $action = $request->input('action');

            $nextLanguage = Language::orderBy('priority', 'asc')->skip($lang->id)->first()->id;
            switch ($action) {
                case 'edit':
                    return redirect()->route('news-edit', [$article->id, $nextLanguage]);
                    break;
                case 'addAnother':
                    return redirect()->route('news-create');
                    break;
                case 'goToList':
                    return redirect()->route('news-list', $defaultLanguage->id);
                    break;
            }
        }

        $formData = [
            "title" => "",
            "description" => "",
            "text" => "",
            "seo_title" => "",
            "seo_description" => "",
            "seo_keywords" => "",
            "image" => "",
            "publish_date" => ""
        ];
        
        
        if($value){
            foreach ($formData as $key => $aleksa) {
                if(isset($value->$key)){
                    $formData[$key] = $value->$key;
                }
            }
        }

        return view('news.edit', compact('otherLanguages', 'lang', 'value', 'formData', 'article'));
        
    }
    
    public function deleteImage($article, $lang){
        $articleForImageDeletion = NewsContent::where('news_id', '=', $article)->where('language_id', '=', $lang)->first();
        $defaultLanguage = Language::orderBy('priority', 'asc')->first();
        
        $articleForImageDeletion->image = "";
        $articleForImageDeletion->save();
        
        // set message to other page
        session()->flash('message', [
            'status' => 'success',
            'text' => "Image for article: $articleForImageDeletion->title was deleted successfully"
        ]);
        
        return redirect()->route('news-list', $defaultLanguage->id);
        
    }

    public function changeStatus($article, $lang) {
        $articleForStatusChange = NewsContent::where('news_id', '=', $article)->where('language_id', '=', $lang)->first();
        $defaultLanguage = Language::orderBy('priority', 'asc')->first();
        
        if($articleForStatusChange->visible == 1){
            $articleForStatusChange->visible = 0;
            
            // set message to other page
            session()->flash('message', [
                'status' => 'success',
                'text' => "Page: $articleForStatusChange->title was hidden successfully"
            ]);
        }else{
            $articleForStatusChange->visible = 1;
            
            // set message to other page
            session()->flash('message', [
                'status' => 'success',
                'text' => "Page: $articleForStatusChange->title was activated successfully"
            ]);
        }
        
        $articleForStatusChange->save();
        
        return redirect()->route('news-list', $defaultLanguage->id);
    }
    
    public function delete($article, $lang) {
        $articleForDelete = NewsContent::where('news_id', '=', $article)->where('language_id', '=', $lang)->first();
        $defaultLanguage = Language::orderBy('priority', 'asc')->first();
        
        $articleForDelete->deleted = 1;
        $articleForDelete->save();
        
        // set message to other page
        session()->flash('message', [
            'status' => 'success',
            'text' => "The article: $articleForDelete->title was deleted successfully"
        ]);

        return redirect()->route('news-list', $defaultLanguage->id);
    }
}
