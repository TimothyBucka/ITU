<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Body_data_model extends Model
{
    use HasFactory;

    protected $table = 'body_data';
    public $timestamps = false;
}
