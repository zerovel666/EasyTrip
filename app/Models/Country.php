<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name_country',
        'name_recreation',
        'name_city',
        'price_per_day',
        'image_path',
    ];

    protected $table = 'countries';
}
