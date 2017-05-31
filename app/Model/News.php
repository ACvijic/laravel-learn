<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\NewsContent;

class News extends Model
{
    public function content() {
        return $this->hasMany(NewsContent::class, 'news_id');
    }
}
