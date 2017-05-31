<?php
namespace App\Helpers;

use App\Model\Page;

class PageHelper
{
    
    /**
     * 
     * @param Page $page
     * @param type $size
     * @return path of the image with the given size ($size)
     */
    public static function imagePath(Page $page, $size = "l") {
        if(isset($page->image)){
            $extension = pathinfo($page->image, PATHINFO_EXTENSION); 
            $extension = substr($page->image, -(strlen($extension) + 1));
            $path = str_replace($extension, "-". $size . $extension, $page->image);
            return $path;
        } else {
            $path = "/default/no-image-icon.jpg";
            return $path;
        }
    }
}

















?>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

