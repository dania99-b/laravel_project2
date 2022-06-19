<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reserv_places extends Model
{

    use HasFactory;

    protected $table = "reserv_places";
    protected  $fillable=
        [
        'trip_user_id',
        'place_id',
        'id',
        'reservation_price'
        ];
}
