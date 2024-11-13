<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

use App\Models\Code;

use Illuminate\Http\Request;
use App\Traits\PaginateWithFormat;
use App\Traits\AddOperationsToQuery;


class CodeRepository extends BaseRepository
{
    use PaginateWithFormat;
    use AddOperationsToQuery;

    public function __construct()
    {
    }

    public function model()
    {
        return "App\\Models\\Code";
    }

    public function findById($codeId)
  	{
        $code = Code::where('id',$codeId)->first();
        if(!$code){
            throw new \Exception('No code found',404);
        }
        return $code;

    }

    public function findByValue($value)
    {
      $code = Code::where('value',$value)->first();
      if(!$code){
          throw new \Exception('Incorrect code',404);
      }
      return $code;

  }


    public function getAll($conditions)
    {
        return Code::all();

    }


}
