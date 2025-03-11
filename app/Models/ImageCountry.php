<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImageCountry extends Model
{
    use HasFactory;
    protected $fillable = [
        'country_id',
        'image_path'
    ];

    protected $table = 'image_countries';

    public function countries() :BelongsTo
    {
        return $this->belongsTo(Country::class,'id','country_id');
    }
}
