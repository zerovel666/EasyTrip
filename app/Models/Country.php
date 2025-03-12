<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        'country_name',
        'trip_name',
        'city_name',
        'price_per_day',
        'count_place',
        'image_path',
        'currency',
    ];

    protected $table = 'countries';

    public function descriptionCountry() :HasOne
    {
        return $this->hasOne(descriptionCountry::class,'country_id','id');
    }
    public function tags():HasMany
    {
        return $this->hasMany(Tags::class,'country_id','id');
    }

    public function imageCountries():HasOne
    {
        return $this->hasOne(ImageCountry::class,'country_id','id');
    }

    public function bookings() :HasMany
    {
        return $this->hasMany(Booking::class,'country_id','id');
    }
}
