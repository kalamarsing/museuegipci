<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

use App\Models\Page;

use Illuminate\Http\Request;
use App\Traits\PaginateWithFormat;
use App\Traits\AddOperationsToQuery;


class PageRepository extends BaseRepository
{
    use PaginateWithFormat;
    use AddOperationsToQuery;

    public function __construct()
    {
    }

    public function model()
    {
        return "App\\Models\\Page";
    }

    public function findById($pageId)
  	{
        $page = Page::where('id',$pageId)->first();
        if(!$page){
            throw new \Exception('No page found',404);
        }
        return $page;

    }


    public function getAll($conditions)
    {
        return Page::all();

    }


}
