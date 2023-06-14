<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Orders;

class PaymentMethod extends Model
{
     public function order(){
     	
     	return $this->hasMany(Orders::class);
     	
    }
}
