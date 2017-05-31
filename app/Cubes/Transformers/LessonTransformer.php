<?php namespace App\Cubes\Transformers;

class LessonTransformer extends Transformer {
    /**
     * Transform a lesson
     * 
     * @param  $lesson
     * @return array
     */
    public function transform($lesson){
        return [
            'title' => $lesson['title'],
            'body' => $lesson['body'],
            'status' => (boolean) $lesson['some_bool']
        ];
    }
}

