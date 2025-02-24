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

    protected $hidden = ['password'];

    protected $casts = [
        'password' => 'hashed', // Laravel 10+ автоматически хеширует пароли
    ];

    protected $table = 'users';
}
