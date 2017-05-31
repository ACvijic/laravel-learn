<?php namespace App\Cubes\Transformers;

abstract class Transformer {
    /**
     * Transform a collection
     * 
     * @param type $lessons
     * @return array
     */
    public function transformCollection(array $items){
        return array_map([$this, 'transform'], $items);
    }
    
    public abstract function transform($lesson);
}

