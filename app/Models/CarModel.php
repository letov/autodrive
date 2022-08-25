<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;

    protected $fillable = ['name','mark_id'];

    public function generations()
    {
        return $this->hasMany(Generation::class, 'car_model_id','id');
    }

    public function mark()
    {
        return $this->hasOne(Mark::class, 'id', 'mark_id');
    }
}
