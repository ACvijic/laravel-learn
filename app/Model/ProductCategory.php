<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Product;

class ProductCategory extends Model
{    
    /**
     * 
     * get the products for the category
     */
    public function products() {
        return $this->hasMany(Product::class, 'category_id');
    }
    
    /**
     * Scope a query to only include active categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('deleted', '=', '0');
    }
    
    /**
     * Scope a query to only include visible categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible($query)
    {
        return $query->where('visible', '=', '1');
    }
    
}
