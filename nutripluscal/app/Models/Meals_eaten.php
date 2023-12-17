<?php
// ######################################### FILE: restaurants.vue ###############################################
// Authors: Adam Pap (xpapad11)
// ############################################################################################################### 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meals_eaten extends Model
{
    use HasFactory;

    protected $table = 'eaten';

    public $timestamps = false;

    public function meals()
    {
        return $this->belongsTo(Meal::class , 'meal_id', 'id');
    }
}
