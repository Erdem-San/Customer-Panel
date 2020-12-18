<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function getData(){
      return $this->hasMany('App\Models\Datapanel','name','name');
    }
}
