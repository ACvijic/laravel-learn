<?php
namespace App\Helpers;

use App\Model\ProductCategory;

class CategoryHelper
{
    
    /**
     * 
     * @param ProductCategory $category
     * @param type $size
     * @return path of the image with the given size ($size)
     */
    public static function imagePath(ProductCategory $category, $size = "l") {
        if(isset($category->image)){
            $extension = pathinfo($category->image, PATHINFO_EXTENSION); 
            $extension = substr($category->image, -(strlen($extension) + 1));
            $path = str_replace($extension, "-". $size . $extension, $category->image);
            return $path;
        } else {
            $path = "/default/no-image-icon.jpg";
            return $path;
        }
    }
}

