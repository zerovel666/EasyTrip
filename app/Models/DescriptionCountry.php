<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DescriptionCountry extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'description',
        'preview',
        'rating',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];
    

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class,'id','country_id');
    }
}
