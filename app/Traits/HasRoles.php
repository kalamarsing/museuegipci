<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
use App\Exceptions\PermissionDoesNotExistException;

trait HasRoles
{

    public function hasRole($role ) {

        if ($this->role && $this->role->identifier == $role) {
            return true;
        }
        
        return false;
      }


}
