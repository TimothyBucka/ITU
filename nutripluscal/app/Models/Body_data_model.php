<?php

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
}
