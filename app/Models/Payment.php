<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    protected $fillable = [
        'num_pay',
        'user_id',
        'phone',
        'email',
        'full_name',
        'type',
        'num_card',
        'fn_mn_card',
        'trip_name',
        'amount',
        'currency',
        'paid',
        'active',
    ];

    protected $table = 'payments';
}
