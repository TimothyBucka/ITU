<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meals_eaten extends Model
{
    use HasFactory;

    protected $table = 'meals_eaten';

    public $timestamps = false;

    public function meals()
    {
        return $this->belongsTo(Meal::class);
    }
}
