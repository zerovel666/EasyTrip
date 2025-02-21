<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LikeCountry extends Model
{
    protected $fillable = [
        'user_id',
        'country_id',
        'estimation'
    ];

    public function users():HasOne
    {
        return $this->hasOne(User::class);
    } 
}
