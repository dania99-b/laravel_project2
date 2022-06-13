<?php

namespace App\Models;

use App\Traits\functrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

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
    public static function boot()
    {
        parent::boot();
        static::deleted(function($obj) {
            \Storage::disk('public_folder')->delete($obj->image);
        });
    }


    public function setphotoAttribute($value)
    {
        $attribute_name = "photo";
        // you can check here if file is recieved or not using hasFile()
        $disk = "public";
        $destination_path = "/appimages";

        \Storage::disk('public')->put('file.png',file_get_contents($value->getRealPath()));

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }
// ..
}
