<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table = 'places';
    use HasFactory;
    protected $fillable=[
        'id',
        'place_name',
        'time_open',
        'time_close',
        'fees',
        'location',
        'langtiude',
        'latitude',
        'rate',
        'photo'

    ];
    public $timestamps = false;
public function country(){
    $this->belongsTo(Country::class);
}
}
