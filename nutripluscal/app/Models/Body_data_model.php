<?php
// ######################################### FILE: restaurants.vue ###############################################
// Authors: Timotej Bucka (xbucka00)
// ############################################################################################################### 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Body_data_model extends Model
{
    use HasFactory;

    protected $table = 'body_data';
    public $timestamps = false;

    public static function calculateBMI($height, $weight)
    {
        if ($height == 0 || $weight == 0)
            return null;
        
        $height = $height / 100;
        $height = $height * $height;
        
        return round($weight / $height, 1);
    }

    public static function calculateDailyIntake($height, $weight, $age, $goal_target)
    {
        $bmr = 13.397 * $weight + 4.799 * $height - 5.677 * $age + 88.362;
        $bmr *= 1.4;

        $weight_diff = $goal_target - $weight;

        $additional = 0;

        if (abs($weight_diff) <= 2) {
            $additional = 0.08 * $bmr;
        } else if (abs($weight_diff) <= 10) {
            $additional = 0.17 * $bmr;
        } else {
            $additional = 0.44 * $bmr;
        }

        $result = 0;
        if ($weight_diff > 0) {
            $result = $bmr + $additional;
        } else if ($weight_diff < 0) {
            $result = $bmr - $additional;
        } else {
            $result = $bmr;
        }

        return round($result, 0);
    }
}
