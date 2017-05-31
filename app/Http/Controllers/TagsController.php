<?php

namespace App\Http\Controllers;

use App\Model\Tag;
use App\Cubes\Transformers\TagTransformer as TagTransformer;
use Illuminate\Http\Request;
use App\Model\Lesson;

class TagsController extends ApiController
{
    
    protected $tagTransformer;
    
    function __construct(TagTransformer $tagTransformer){
        $this->tagTransformer = $tagTransformer;
    }
    
    /**
     * 
     * @param null $id
     * @return Response
     */
    public function index($lessonId = null){
        
        $tags = $this->getTags($lessonId);
        
        return $this->respond([
            'data' => $this->tagTransformer->transformCollection($tags->all()),
        ]);
    }
    
    public function show($id){
        $tag = Tag::find($id);

        if (!$tag) {
            return $this->respondNotFound('Tag does not exist.');
        }

        return $this->respond([
            'data' => $this->tagTransformer->transform($tag),
                //'data' => $this->transform($lesson->toArray()),
        ]);
    }
    
    public function getTags($lessonId){
        $tags = $lessonId ? Lesson::findOrFail($lessonId)->tags : Tag::all();
        
        return $tags;
    }
    
}
