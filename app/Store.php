<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public $timestamps = false;

    public function users(){
	    
        return $this->belongsToMany('App\User', 'store_user');
    }

    public function skus(){
    	return $this->belongsToMany('App\Sku', 'store_sku');
    }

    public function customer(){
    	return $this->belongsTo('App\Customer');
    }

    public function area(){
    	return $this->belongsTo('App\Area');
    }

    public function premise(){
    	return $this->belongsTo('App\Premise');
    }
}
