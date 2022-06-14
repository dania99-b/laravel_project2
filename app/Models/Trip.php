<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $fillable=[
        'id',
        'place_name',
        'trip_name',
        'photo',
        'trip_start',
        'duration',
        'trip_end',
        'trip_plane',
        'trip_status',
        'price',
        'note',
        'available_num_passenger',
        'user_id'];

    public $timestamps = false;

public function places()
{
    return $this->belongsToMany(Place::class,'trip_place');
}


    public function scopeUser(){
        return $this->belongsToMany(User::class)->withPivot( 'reservation_date','part_money','passenger_number');
    }

    public function scopeOfficer()
    {
        return $this->belongsTo(User::class)->where('role', 'officer');
    }






}
