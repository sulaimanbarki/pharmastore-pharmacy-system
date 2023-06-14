<?php

namespace App;
use App\Product;

use Illuminate\Database\Eloquent\Model;

class GenericNames extends Model
{
   public function product(){

    	return $this->hasMany(Product::class);
    	
    }
}
