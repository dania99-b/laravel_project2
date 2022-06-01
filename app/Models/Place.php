<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class place extends Model
{
    protected $table = 'places';
    use HasFactory;
    protected $fillable=[
        'place_name',
        'time_open',
        'time_close',
        'fees',
        'langtiude',
        'latitude'

    ];
    public $timestamps = false;
public function country(){
    $this->belongsTo(Country::class);
}
}
