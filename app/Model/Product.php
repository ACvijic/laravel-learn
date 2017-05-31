<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ProductCategory;
use App\Model\Comment;

class Product extends Model
{
    
    public function category() {
        return $this->belongsTo(ProductCategory::class, 'id');
    }
    
    public function scopeGetSimilar($query, $num){
        return $query->where("category_id", "=", $this->category_id)
                                ->where("id", "!=", $this->id)
                                ->active()
                                ->visible()
                                ->take($num)
                                ->get();
    }
    
    public function scopeGetComments() {
        $comments = Comment::where('product_id', '=', $this->id)->where('comment_id', '=', 0)->get();
        return $comments;
    }
    
    public function numberOfComments() {
        $numberOfComments = count($this->getComments());
        return $numberOfComments;
    }
    
    /**
     * Scope a query to only include active products.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('deleted', '=', '0');
    }
    
    /**
     * Scope a query to only include visible products.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible($query)
    {
        return $query->where('visible', '=', '1');
    }
    
    public function getSlug(){
        return "/product/" . $this->id . "/" . str_slug($this->name);
    }
}
