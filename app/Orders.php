<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PaymentMethod;
use App\Product;
use App\Order_Product;

class Orders extends Model
{
    protected $primaryKey = "order_id";

    public function payment(){
        return $this->belongsTo(PaymentMethod::class,'payment_type');
    }

    public function products()
    {
        
        return $this->hasMany('App\Order_Product', 'order_id', 'order_id');
        
    }
}
