<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class info extends Model
{
    protected $table='info';
   public function user(){
        return $this->belongsTo('App\User','user_id','id');
   }
}
