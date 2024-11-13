<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

use App\Models\Language;

use Illuminate\Http\Request;
use App\Traits\PaginateWithFormat;
use App\Traits\AddOperationsToQuery;


class LanguageRepository extends BaseRepository
{
    use PaginateWithFormat;
    use AddOperationsToQuery;

    public function __construct()
    {
    }

    public function model()
    {
        return "App\\Models\\Language";
    }

    public function findById($languageId)
  	{
        $language = Language::where('id',$languageId)->first();
        if(!$language){
            throw new \Exception('No language found',404);
        }
        return $language;

    }


    public function getAll($conditions)
    {
        return Language::all();

    }


}
