<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $fillable=[
        'id',
        'country_name',
        'photo',
        'langtiude',
        'latitude'
        ];
    public $timestamps = false;
    use HasFactory;
    public function place(){
        return $this->hasMany(Place::class);
    }
}
