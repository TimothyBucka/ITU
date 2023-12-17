<?php
// ######################################### FILE: Meal.php ###############################################
// Authors: Adam Pap (xpapad11)
// ############################################################################################################### 

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
       return $this->hasMany(Meals_eaten::class, 'meal_id', 'id');
    }
}
