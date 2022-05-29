<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable=[

        'id',
        'admin_name',
        'admin_email',
        'password',
        'admin_phone'
    ];
    public $timestamps = false;

}
