<?php

namespace App\Model;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function topmenu(){
        return $this->belongsTo(Menu::class, 'parent_id');
    }
    
    public function submenus(){
        return $this->hasMany(Menu::class, 'parent_id');
    }
    
    public function scopeVisible($query, $value = 1) {
        return $query->where('visible', '=', $value);
    }
    
    public function scopeNotDeleted($query) {
        return $query->where('deleted', '=', 0);
    }
    
    public function scopePosition($query, $value) {
        $query->where('position', 'like', "%#$value#%");
    }
    
    public function scopeFirstLevelMenu($query){
        return $query->where('parent_id', '=', 0);
    }
    
    public function scopeWithParent($query, $parentId){
        return $query->where('parent_id', '=', $parentId);
    }
    
    public static function getLastPosition($parentId){
        $row = Menu::where('parent_id', '=', $parentId)->orderBy('priority', 'desc')->first();
        if(!empty($row)){
            return $row->priority + 1;
        }else{
            return 0;
        }
    }
    
    public function getSlug($menu) {
        $tempArray = array();
        if ($menu->parent_id != 0) {
            array_push($tempArray, str_slug($menu->title), $menu->getSlug($menu->topmenu));
        } else {
            array_push($tempArray, str_slug($menu->title));
        }
        krsort($tempArray);
        $slug =implode("/", $tempArray);
        return $slug;
    }
    
    public function getSlugEasier() {
        switch ($this->type){
            
            case 'just-title':
                return "#";
            break;
        
            case 'internal-link':
            case 'external-link':
                return $this->type_value;
            break;
        
            case 'page':
                return "/page/" . $this->type_value . "/" . str_slug($this->title);
            break;
        
            case 'products':
                return "/category/" . $this->type_value . "/" . str_slug($this->title);
            break;
            case 'news':
                return "/news/list" . $this->type_value;
            break;
        
        }
    }

    public static function getAllRoutes() {
        $allRoutes = array();
        $menus = Menu::all();
        foreach ($menus as $menu) {
            $allRoutes[$menu->id] =  "/" .  $menu->getSlug($menu);
        }
        return $allRoutes;
    }
}
