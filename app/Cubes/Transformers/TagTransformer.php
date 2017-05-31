<?php namespace App\Cubes\Transformers;

class TagTransformer extends Transformer {
    /**
     * Transform a lesson
     * 
     * @param  $tag
     * @return array
     */
    public function transform($tag){
        return [
            'name' => $tag['name']
        ];
    }
}

