<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    public $timestamps = false;

    public function division(){
    	return $this->belongsTo('App\Division');
    }

    public function category(){
    	return $this->belongsTo('App\Category');
    }

    public function subcategory(){
    	return $this->belongsTo('App\SubCategory');
    }

    public function brand(){
    	return $this->belongsTo('App\Brand');
    }
}
