<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'password',
        'iin',
        'role'
    ];

    protected $casts = [
        'password' => 'hashed', 
    ];

    protected $table = 'users';

    public function bookings() :HasMany
    {
        return $this->hasMany(Booking::class,'user_id','id');
    }
}
