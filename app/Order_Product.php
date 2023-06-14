<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_Product extends Model
{
    protected $table = "order_products";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['order_id','product_id','price','qty','total','discount_type','discount','grand_total'];

    public function order(){

        return $this->belongsTo('App\Orders','order_id');

    }

    public function product()
    {

        return $this->hasOne('App\Product', 'id', 'product_id');
        
    }
}
