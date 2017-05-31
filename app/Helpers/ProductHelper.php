<?php
namespace App\Helpers;

use App\Model\Product;

class ProductHelper
{
    
    /**
     * 
     * @param Product $product
     * @param type $size
     * @return path of the image with the given size ($size)
     */
    public static function imagePath(Product $product, $size = "l") {
        if(isset($product->image)){
            $extension = pathinfo($product->image, PATHINFO_EXTENSION); 
            $extension = substr($product->image, -(strlen($extension) + 1));
            $path = str_replace($extension, "-". $size . $extension, $product->image);
            return $path;
        } else {
            $path = "/default/no-image-icon.jpg";
            return $path;
        }
    }
}

















?>
