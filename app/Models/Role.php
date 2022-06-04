<?php

namespace App\Models;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    
    public $guarded = [];
}
