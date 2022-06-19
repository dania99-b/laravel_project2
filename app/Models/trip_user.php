<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trip_user extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = "trip_user";
protected  $fillable=[
    'trip_id',
    'user_id',
    'reservation_date',
    'total_money',
    'passenger_number'
    ,'created_at',
    'updated_at',
    'id',
    'reserv_places_id',
    'reservation_price'

    ];
    public function places(){
        return $this->belongsToMany(Place::class,'reserv_places');
    }

}
