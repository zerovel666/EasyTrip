<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    protected $fillable = [
        'num_pay',
        'user_id',
        'amount',
        'currency',
        'paid',
        'name_recreation',
        'active'
    ];

    protected $table = 'payments';

}
