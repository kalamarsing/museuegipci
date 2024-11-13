<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

use App\Models\User;

use Illuminate\Http\Request;
use App\Traits\PaginateWithFormat;
use App\Traits\AddOperationsToQuery;


class UserRepository extends BaseRepository
{
    use PaginateWithFormat;
    use AddOperationsToQuery;

    public function __construct()
    {
    }

    public function model()
    {
        return "App\\Models\\User";
    }

    public function findById($userId)
  	{
        $user = User::where('id',$userId)->first();
        if(!$user){
            throw new \Exception('No user found',404);
        }
        return $user;

    }


    public function getAll($conditions)
    {
        return User::all();

    }


}
