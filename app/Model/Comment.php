<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Product;
use App\Model\Comment;

class Comment extends Model
{
    public function product() {
        return $this->belongsTo(Product::class, 'id');
    }
    
    public function commentedOn() {
        return $this->hasMany(Comment::class, 'comment_id');
    }
    
    public function scopeActive($query) {
        return $query->where('status', '=', 1);
    }
    
    public function scopeBanned($query) {
        return $query->where('status', '=', 0);
    }
    
    public function scopeReported($query) {
        return $query->where('reported', '=', 1);
    }
    
    public function scopeNotRepoted($query) {
        return $query->where('reported', '=', 0);
    }
    
    public static function countComments($filters = []) {

        if (!empty($filters)) {
            $count = Comment::proccessFilter($filters)->count();
        } else {

            $count = Comment::count();
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
                    $query->where('name', 'like', "%$value%")
                            ->orWhere('email', 'like', "%$value%")
                            ->orWhere('title', 'like', "%$value%")
                            ->orWhere('text', 'like', "%$value%");
                            // ->orWhere(product_id or comment_id (titles of their parents/children), 'like', "%$value%");
                });
            }
            if ($key == 'reported') {
                $query->where('reported', '=', $value);
            }
            if ($key == 'active') {
                $query->where('status', '=', $value);
            }
        }
        foreach ($filters['like'] as $key => $value) {
            $query->where($key, 'like', '%' . $value['search']['value'] . '%');
        }
        return $query;
    }

    public static function search($parameters) {
        $result = Comment::order($parameters['order']);
        $result = $result->skip($parameters['limit'] * $parameters['page'])->take($parameters['limit']);
        $result = $result->proccessFilter($parameters['filters'])->get();
        return $result;
    }
    
}
