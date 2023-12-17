<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurants extends Model
{
    use HasFactory;
    protected $table = 'restaurants';

    public $timestamps = false;

    public function meals()
    {
        return $this->hasMany(Meal::class, 'restaurant_id');
    }
}
