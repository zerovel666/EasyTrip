<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefreshPassword extends Model
{
    protected $fillable = [
        'user_id',
        'url'
    ];
    
    protected $table = 'refresh_passwords';
}
