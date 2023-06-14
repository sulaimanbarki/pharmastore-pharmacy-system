<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $primaryKey = 'payment_id';

    protected $fillable = ['card_charge_id', 'card_customer', 'card_paid', 'card_payment_method'];
}
