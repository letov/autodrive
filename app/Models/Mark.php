<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function carModels()
    {
        return $this->hasMany(CarModel::class, 'mark_id','id');
    }
}
