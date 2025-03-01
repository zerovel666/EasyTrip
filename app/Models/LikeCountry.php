<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LikeCountry extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'country_id',
        'estimation'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($like) {
            $like->updateRating();
        });

        static::updated(function ($like) {
            $like->updateRating();
        });

        static::deleted(function ($like) {
            $like->updateRating();
        });
    }

    protected function updateRating()
    {
        $description = DescriptionCountry::where('country_id', $this->country_id)->first();

        if (!$description) {
            return;
        }

        $averageEstimation = self::where('country_id', $this->country_id)->avg('estimation') ?? 3;

        $description->update(['rating' => $averageEstimation]);
    }
}
