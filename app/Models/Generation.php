<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
    use HasFactory;

    protected $fillable = ['id','name','car_model_id'];

    public function carModel()
    {
        return $this->hasOne(CarModel::class, 'id', 'car_model_id');
    }
}
