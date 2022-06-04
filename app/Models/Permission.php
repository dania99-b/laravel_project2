<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;
use Laratrust\Traits\LaratrustUserTrait;

class Permission extends LaratrustPermission
{

    public $guarded = [];
}
