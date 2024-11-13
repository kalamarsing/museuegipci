<?php

namespace App\Traits;


trait PaginateWithFormat
{

    public function paginateWithFormat($query, $perPage = 10, $page = 0, $columns = '*', $paginationName = 'page' ) {

        $query = $this->paginateWithoutFormat($query, $perPage, $page, $columns, $paginationName);
            return  $query->all();
      //  return $this->applyPaginationFormat($query, $query->all());

    }
    public function  paginateWithRolesAndPermissionsFormat($query, $perPage = 10, $page = 0, $columns = '*', $paginationName = 'page' ) {

        $query = $this->paginateWithoutFormat($query, $perPage, $page, $columns, $paginationName);

        return $this->applyPaginationFormat($query, $this->processRolesAndPermissionsOnResponse($query));

    }

    public function paginateWithoutFormat($query, $perPage = 10, $page = 1, $columns = '*', $paginationName = 'page' ) {


        if($perPage == null)
            $perPage = 10;
        
        if($page == null)
            $page = 1;

        return $query->paginate($perPage, [$columns], $paginationName, $page);
        
    }

    public function applyPaginationFormat($query, $results) {


        $result = (object)[];
        $result->total = $query->total() ;
        $result->perPage = (int)$query->perPage();
        $result->page = $query->currentPage();
        $result->totalPage = $query->lastPage() ;
        $result->from = $query->toArray()['from'] ;
        $result->to = $query->toArray()['to'] ;
        $result->data = $results ;
        
        return $result;
    }

    public function processRolesAndPermissionsOnResponse($query){

        $roles = \App\Models\Role::pluck('id', 'identifier');
        $permissions = \App\Models\Permission::pluck('id', 'identifier');

        $data =  collect($query->items())->map(function($user) use ($roles, $permissions) {
            $userRoles = (object) [];
            $userPermissions = (object) [];
            $userPermissionsArray = $user->permissions()->pluck('id')->toArray();

            foreach ($roles as $roleName => $roleId) {
                $userRoles->{$roleName} = $user->role_id == $roleId ? 'Y':'N';
            }
            $user->roles = $userRoles;

            foreach ($permissions as $permissionName => $permissionId) {
                $userPermissions->{$permissionName} = in_array($permissionId, $userPermissionsArray) ? 'Y':'N';
            }
            $user->permissions = $userPermissions;

            return $user;
        });

        return $data;

    }


}
