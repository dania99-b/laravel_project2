<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Officer extends Model
{
use HasApiTokens, HasFactory, Notifiable;
    protected $fillable=[

        'id',
        'office_name',
        'office_email',
        'password',
        'office_phone'
    ];
    public $timestamps = false;
}
