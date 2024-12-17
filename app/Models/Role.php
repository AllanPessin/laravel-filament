<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Contracts\Role as RoleInterface;
use Spatie\Permission\Models\Role as RoleModel;

class Role extends RoleModel implements RoleInterface
{
    protected $guard = 'web';
}
