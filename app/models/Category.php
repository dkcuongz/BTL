<?php

namespace App\models;

use Illuminate\Auth\Events\Failed;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    public function product(){
        return $this->hasMany('App\models\Product','category_id','id');
   }
    public $timestamps = false;
}
