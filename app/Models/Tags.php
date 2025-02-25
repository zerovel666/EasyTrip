<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tags extends Model
{
    use HasFactory;
    protected $fillable = [
        'country_id',
        'tag'
    ];

    protected $table = 'tags';

    public function countries() :BelongsTo
    {
        return $this->BelongsTo(Country::class,'id','country_id');
    }
}
