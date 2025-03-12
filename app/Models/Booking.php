<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{   
    protected $fillable = [
        'country_id',
        'user_id',
        'check_in',
        'check_out',
        'active',
        'uuid',
        'users_iins',
    ];

    protected $table = 'bookings';

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class,'id','user_id');
    }
    public function countries(): BelongsTo
    {
        return $this->belongsTo(Country::class,'id','country_id');
    }

    
}
