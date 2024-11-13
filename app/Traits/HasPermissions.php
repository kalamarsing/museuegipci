<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
use App\Exceptions\PermissionDoesNotExistException;

trait HasPermissions
{
    /**
     * permissions.
     *
     * @return void
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions', 'user_id', 'permission_id');
    }



    /**
     * Check if user has permission
     * Disabled/Enabled permission are prioritary.
     *
     * @param mixed $identifier
     *
     * @return void
     */
    public function hasPermission($identifier)
    {
        $permission = $this->getPermissionByIdentifier($identifier);

        return (bool) $this->permissions->where('identifier', $permission->identifier)->count();

    }

    /**
     * Check if user has one permission of this array of permissions.
     *
     * @param mixed $identifiers
     *
     * @return bool
     */
    public function hasOnePermission($identifiers)
    {
        $satisfy = false;
        foreach ($identifiers as $identifier) {
            if ($this->hasPermission($identifier)) {
                $satisfy = true;
            }
        }

        return $satisfy;
    }


        /**
     * Check if user has all permissions of this array of permissions.
     *
     * @param mixed $identifiers
     *
     * @return bool
     */
    public function hasAllPermissions($identifiers)
    {
        $satisfy = true;
        foreach ($identifiers as $identifier) {
            if (!$this->hasPermission($identifier)) {
                $satisfy = false;
            }
        }

        return $satisfy;
    }


    /**
     * Retrive permission by his identifier.
     *
     * @param string $role
     *
     * @return Role
     */
    private function getPermissionByIdentifier($permission)
    {
        if (!is_object($permission)) {
            $permission = Permission::where('identifier', $permission)->first();

            if (!$permission) {
                throw new PermissionDoesNotExistException($permission);
            }
        }

        if (!is_a($permission, Permission::class)) {
            throw new PermissionDoesNotExistException($permission);
        }

        return $permission;
    }
}
