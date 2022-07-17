<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable=[
        'id',
        'trip_name',
        'photo',
        'trip_start',
        'duration',
        'trip_end',
        'trip_plane',
        'trip_status',
        'price_after_discount',
        'note',
        'available_num_passenger',
        'user_id',
        'trip_user_id',
        'total_trip_price',
        'discounts',
        'place_in_trip_price'];

    public $timestamps = false;

public function places()
{
    return $this->belongsToMany(Place::class,'trip_place')->withPivot('place_trip_price');
}


    public function scopeUser(){
        return $this->belongsToMany(User::class, 'trip_user')->withPivot( 'reservation_date','total_money','passenger_number');
    }

    public function scopeOfficer()
    {
        return $this->belongsTo(User::class)->where('role', 'officer');
    }






}
