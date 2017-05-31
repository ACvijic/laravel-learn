<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    
    public static function incrementLastPriority() {
        $lastLang = Language::orderBy('priority', 'desc')->first();
        
        return $lastLang->priority ++;
    }
    
    public static function defaultLang() {
        $lastLang = Language::orderBy('priority', 'asc')->first();
        return $lastLang;
    }
    public static function defaultLangId() {
        $lastLangId = Language::orderBy('priority', 'asc')->first()->id;
        return $lastLangId;
    }
}
