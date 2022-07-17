<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    use HasFactory;
    protected  $fillable=
        [   'id',
            'country_name',
            'langtiude',
            'latitude',



        ];
    public $timestamps = false;
}
