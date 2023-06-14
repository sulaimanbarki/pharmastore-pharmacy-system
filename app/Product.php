<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Category;
use App\GenericNames;
use App\MedicineGroup;
use App\Supplier;
use App\Orders;

class Product extends Model
{
   use Notifiable;

   protected $table = 'product';

   public function category(){
        
        return $this->belongsTo(Category::class,'category_id');

    }
    public function generic(){

        return $this->belongsTo(GenericNames::class,'generic_id');

    }
    public function supplier(){

        return $this->belongsTo(Supplier::class,'supplier_id');

    }
    public function group(){

        return $this->belongsTo(MedicineGroup::class,'group_id');

    }
    public function order(){

        return $this->hasMany(Orders::class);
        
    }

}
