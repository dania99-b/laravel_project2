<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    use HasFactory;
    protected  $fillable=
        [   'id',
            'title',
            'body',
            'created_at',
            'updated_at'

        ];
    public function users(){
        return $this->belongsToMany(User::class, 'user_notification')->withPivot( 'reservation_date','part_money','passenger_number');
    }
}
