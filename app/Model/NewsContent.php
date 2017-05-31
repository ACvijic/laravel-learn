<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Input\Input;
use App\Model\Language;

class NewsContent extends Model
{
    public function article() {
        return $this->belongsTo(News::class, 'news_id', 'id');
    }
    
    public function language() {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
    
    public function scopeNotDeleted($query) {
        return $query->where('deleted', '=', 0);
    }
    public function scopeCurrentLanguage($query, $lang) {
        return $query->where('language_id', '=', $lang);
    }
    
    public function scopeHasImage($query) {
        return $query->where('image', '!=', NULL);
    }

    public static function countPosts($lang, $filters = []) {
//        dd($filters);
        if (!empty($filters)) {
            $count = NewsContent::currentLanguage($lang)->proccessFilter($filters)->count();
        } else {

            $count = NewsContent::currentLanguage($lang)->count();
        }

        return $count;
    }
    
    public function scopeOrder($query, $param) {
        foreach ($param as $key => $value) {
            $query->orderBy($key, $value);
        }
        return $query;
    }
    
    public function scopeProccessFilter($query, $filters) {
        if(!empty($filters['equal'])){
            foreach ($filters['equal'] as $key => $value) {
                if ($key == 'all' && !empty($value)) {
                    $query->where(function ($query) use ($value) {
                        $query->where('title', 'like', "%$value%")
                              ->orWhere('text', 'like', "%$value%");
                    });
                    //$query->where('title', 'like', '%'. $value . '%')->orWhere('body', 'like', '%'. $value . '%');
                }
                
                if ($key == 'show_with_status') {
                    $query->where('status', '=', $value);
                }
            }
        }

        if(!empty($filters['like'])){
            foreach ($filters['like'] as $key => $value) {

                

                $query->where($key, 'like', '%' . $value['search']['value'] . '%');
            }
        }

        return $query;
    }
    
    public static function search($parameters) {
        $result = NewsContent::currentLanguage($parameters['lang'])->notDeleted()->order($parameters['order']);
        $result = $result->skip($parameters['limit'] * $parameters['page'])->take($parameters['limit']);
        $result = $result->proccessFilter($parameters['filters'])->get();
        return $result;
    }    
    
}
