<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'iin'
    ];

    protected $table = 'users';

}
