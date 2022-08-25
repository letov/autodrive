<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'mark_id',
        'car_model_id',
        'generation_id',
        'year',
        'run',
        'color_id',
        'body_type_id',
        'engine_type_id',
        'transmission_id',
        'gear_type_id',
    ];

    public static function getAllIds(): array
    {
        return self::select('id')->get()->pluck('id')->toArray();
    }

    public static function deleteUnusedOffers(array $unusedOfferIds): void
    {
        self::whereIn('id', $unusedOfferIds)->delete();
    }
}
