<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Menu;
use App\Model\Page;
use App\Model\ProductCategory;
use App\Model\Language;

class MenusController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Menu $menu) {
        if (!empty($menu->id)) {
            // first level is with parent_id = $menu->id
            $menusFirstLevel = Menu::withParent($menu->id)->orderBy('priority', 'asc')->where('deleted', '=', 0)->get();
            $parentId = $menu->parent_id;
        } else {
            // first level is with parent_id = 0
            $menusFirstLevel = Menu::withParent(0)->orderBy('priority', 'asc')->where('deleted', '=', 0)->get();
            $parentId = 0;
        }
        
        if(count($menusFirstLevel) == 0){
            if($parentId == 0){
                return redirect(route('menus-list', $parentId));
            } else {
                return redirect(route('menus-list'));
            }
        }



        return view('menus.index', compact('menusFirstLevel', 'subMenus', 'menu'));
    }
    
    public function create() {
        $menusNotDeleted = Menu::notDeleted()->get();
        $menusFirstLevel = Menu::firstLevelMenu()->get();
        
        $menuPossibleValues = "0";
        if (count($menusNotDeleted) > 0) {
            foreach ($menusNotDeleted as $value) {
                $menuPossibleValues .= "," . $value->id;
            }
        }
        
        $pages = Page::active()->get();
        $pagesPossibleValues = "";
        if (count($pages) > 0) {
            $i = 0;
            foreach ($pages as $page) {
                if ($i != 0) {
                    $pagesPossibleValues .= ',';
                }
                $pagesPossibleValues .= $page->id;
                $i++;
            }
        }
        
        $categories = ProductCategory::active()->visible()->get();
        $categoriesPossibleValues = "";
        if (count($categories) > 0) {
            $i = 0;
            foreach ($categories as $category) {
                if ($i != 0) {
                    $categoriesPossibleValues .= ',';
                }
                $categoriesPossibleValues .= $category->id;
                $i++;
            }
        }

        
        $defaultLanguage = Language::orderBy('priority', 'asc')->first();
        $otherLanguages = Language::where('id', '!=', $defaultLanguage->id)->get();
        
        $languagesPossibleValues = "$defaultLanguage->short_name";
        if (count($otherLanguages) > 0) {
            $i = 0;
            foreach ($otherLanguages as $language) {
                if ($i != 0) {
                    $languagesPossibleValues .= ',';
                }
                $languagesPossibleValues .= $language->short_name;
                $i++;
            }
        }
        
        if (request()->isMethod('post')) {
            $this->validate(request(), [
                'title' => 'required|max:191',
                'parent_id' => "required|in:$menuPossibleValues",
                'position' => 'required|array',
                'position.*' => 'in:top,header,sidebar,footer',
                'type' => 'required|in:just-title,internal-link,external-link,page,products,news'
            ]);

            $type = request('type');
            $typeValue = NULL;
            switch ($type) {
                case 'internal-link':
                    $this->validate(request(), [
                        'internal-link-value' => 'required'
                    ]);
                    $typeValue = request('internal-link-value');
                    break;
                case 'external-link':
                    $this->validate(request(), [
                        'external-link-value' => 'required|url'
                    ]);
                    $typeValue = request('external-link-value');
                    break;
                case 'page':
                    $this->validate(request(), [
                        'page-value' => "required|in:$pagesPossibleValues"
                    ]);
                    $typeValue = request('page-value');
                    break;
                case 'products':
                    $this->validate(request(), [
                        'category-value' => "required|in:$categoriesPossibleValues"
                    ]);
                    $typeValue = request('category-value');
                    break;
                case 'news':
                    $this->validate(request(), [
                        'language-value' => "required|in:$languagesPossibleValues"
                    ]);
                    $typeValue = request('language-value');
                    break;
            }

            $menu = new Menu();
            $menu->title = request('title');
            $menu->parent_id = request('parent_id');
            $menu->type = request('type');
            $menu->type_value = $typeValue;

            $positions = request('position');
            foreach ($positions as $key => $position) {
                $positions[$key] = "#" . $position . "#";
            }
            $menu->position = implode(",", $positions);
            $menu->priority = Menu::getLastPosition(request('parent_id'));

            $menu->save();

            // set message to other page
            session()->flash('message', [
                'status' => 'success',
                'text' => "Menu: $menu->title was created successfully"
            ]);

            return redirect()->route('menus-list');
        }

        return view('menus.create', compact('menusFirstLevel', 'pages', 'categories'));
    }
    
    public function reorder() {
        $parent = request('menu');
        $menusNewOrder = explode(",", request('new-state'));
        $i = 1;
        if (request()->isMethod('post')) {
            foreach ($menusNewOrder as $order) {
                $menuForReorder = Menu::where('parent_id', '=', $parent)->where('id', '=', $order)->first();
                $menuForReorder->priority = $i;
                $menuForReorder->save();
                $i++;
            }
            session()->flash('message', [
                'status' => 'success',
                'text' => "New order saved successfully"
            ]);

            return back();
        }
    }

    public function edit(Menu $menu) {
        $menusFirstLevel = Menu::firstLevelMenu()->get();
        
        $positionsOld = array();
        if (count($menu->position) > 0) {
            foreach (explode(",", $menu->position) as $value) {
                $positionsOld[] = trim($value, "#");
            }
        }
        $menuPossibleValues = "0";
        if (count($menusFirstLevel) > 0) {
            foreach ($menusFirstLevel as $value) {
                $menuPossibleValues .= "," . $value->id;
            }
        }

        $pages = Page::active()->get();
        $pagesPossibleValues = "";
        if (count($pages) > 0) {
            $i = 0;
            foreach ($pages as $page) {
                if ($i != 0) {
                    $pagesPossibleValues .= ',';
                }
                $pagesPossibleValues .= $page->id;
                $i++;
            }
        }
        
        $categories = ProductCategory::active()->visible()->get();
        $categoriesPossibleValues = "";
        if (count($categories) > 0) {
            $i = 0;
            foreach ($categories as $category) {
                if ($i != 0) {
                    $categoriesPossibleValues .= ',';
                }
                $categoriesPossibleValues .= $category->id;
                $i++;
            }
        }
        
        $defaultLanguage = Language::orderBy('priority', 'asc')->first();
        $otherLanguages = Language::where('id', '!=', $defaultLanguage->id)->get();
        
        $languagesPossibleValues = "$defaultLanguage->short_name";
        if (count($otherLanguages) > 0) {
            $i = 0;
            foreach ($otherLanguages as $language) {
                if ($i != 0) {
                    $languagesPossibleValues .= ',';
                }
                $languagesPossibleValues .= $language->short_name;
                $i++;
            }
        }
        
        if (request()->isMethod('post')) {
            $this->validate(request(), [
                'title' => 'required|max:191',
                'parent_id' => "required|in:$menuPossibleValues",
                'position' => 'required|array',
                'position.*' => 'in:top,header,sidebar,footer',
                'type' => 'required|in:just-title,internal-link,external-link,page,products,news'
            ]);

            $type = request('type');
            $typeValue = NULL;
            switch ($type) {
                case 'internal-link':
                    $this->validate(request(), [
                        'internal-link-value' => 'required'
                    ]);
                    $typeValue = request('internal-link-value');
                    break;
                case 'external-link':
                    $this->validate(request(), [
                        'external-link-value' => 'required|url'
                    ]);
                    $typeValue = request('external-link-value');
                    break;
                case 'page':
                    $this->validate(request(), [
                        'page-value' => "required|in:$pagesPossibleValues"
                    ]);
                    $typeValue = request('page-value');
                    break;
                case 'products':
                    $this->validate(request(), [
                        'category-value' => "required|in:$categoriesPossibleValues"
                    ]);
                    $typeValue = request('category-value');
                    break;
                case 'news':
                    $this->validate(request(), [
                        'language-value' => "required|in:$languagesPossibleValues"
                    ]);
                    $typeValue = request('language-value');
                    break;
            }
            
            // if new parent_id != old parent_id
            
            if(request('parent_id') != $menu->parent_id){
                $menu->priority = Menu::getLastPosition(request('parent_id'));
            }
            
            $menu->title = request('title');
            $menu->parent_id = request('parent_id');
            $menu->type = request('type');
            $menu->type_value = $typeValue;

            $positions = request('position');
            foreach ($positions as $key => $position) {
                $positions[$key] = "#" . $position . "#";
            }
            $menu->position = implode(",", $positions);
            
            $menu->save();

            // set message to other page
            session()->flash('message', [
                'status' => 'success',
                'text' => "Menu: $menu->title was updated successfully"
            ]);
            
            if($menu->parent_id > 0){
                return redirect()->route('menus-list', $menu->id);
            } else {
                return redirect()->route('menus-list');
            }
        }

        return view('menus.edit', compact('menu', 'menusFirstLevel', 'pages', 'positionsOld', 'categories'));
    }

    public function changeStatus(Menu $menu) {
        
        if($menu->visible == 1){
            $menu->visible = 0;
            
            // set message to other page
            session()->flash('message', [
                'status' => 'success',
                'text' => "Menu: $menu->title was hidden successfully"
            ]);
        }else{
            $menu->visible = 1;
            
            // set message to other page
            session()->flash('message', [
                'status' => 'success',
                'text' => "Menu: $menu->title was activated successfully"
            ]);
        }
        
        $menu->save();
        

        return back();
    }

    public function delete(Menu $menu) {
        if(count($menu->submenus) == 0){
            $menu->deleted = 1;
            $menu->save();
            // set message to other page
            session()->flash('message', [
                'status' => 'success',
                'text' => 'Menu: "' . $menu->title  . '" was deleted successfully'
            ]);

            return back();
        } else {
            // set message to other page
            session()->flash('message', [
                'status' => 'danger',
                'text' => 'Menu: "' .  $menu->title . '" has submenus, please move these submenus in order to delete this menu!'
            ]);

            return back();
        }
        
        
    }

}
