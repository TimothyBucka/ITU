<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;
    
    protected $table = 'meals';

    public $timestamps = false;

    public function restaurants()
    {
        return $this->belongsTo(Restaurants::class);
    }

    public function meals_eaten()
    {
        return $this->hasMany(Meals_eaten::class);
    }
}
