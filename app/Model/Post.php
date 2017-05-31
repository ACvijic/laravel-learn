<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {

    public function scopeActive($query) {
        return $query->where('status', '=', 1);
    }

    public function scopeHasImage($query) {
        return $query->where('image', '!=', NULL);
    }

    public static function countPosts($filters = []) {

        if (!empty($filters)) {
            $count = Post::proccessFilter($filters)->count();
        } else {

            $count = Post::count();
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
        foreach ($filters['equal'] as $key => $value) {

            if ($key == 'all' && !empty($value)) {
                $query->where(function ($query) use ($value) {
                    $query->where('title', 'like', "%$value%")
                          ->orWhere('body', 'like', "%$value%");
                });
                //$query->where('title', 'like', '%'. $value . '%')->orWhere('body', 'like', '%'. $value . '%');
            }
            if ($key == 'show_with_status') {
                $query->where('status', '=', $value);
            }
        }
        foreach ($filters['like'] as $key => $value) {
            $query->where($key, 'like', '%' . $value['search']['value'] . '%');
        }
        return $query;
    }

    public static function search($parameters) {
        $result = Post::order($parameters['order']);
        $result = $result->skip($parameters['limit'] * $parameters['page'])->take($parameters['limit']);
        $result = $result->proccessFilter($parameters['filters'])->get();
        return $result;
    }

}
