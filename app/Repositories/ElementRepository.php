<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

use App\Models\Element;
use App\Models\Language;

use Illuminate\Http\Request;
use App\Traits\PaginateWithFormat;
use App\Traits\AddOperationsToQuery;


class ElementRepository extends BaseRepository
{
    use PaginateWithFormat;
    use AddOperationsToQuery;

    public function __construct()
    {
    }

    public function model()
    {
        return "App\\Models\\Element";
    }

    public function findById($elementId)
  	{
        $element = Element::where('id',$elementId)->first();
        if(!$element){
            throw new \Exception('No element found',404);
        }
        return $element;

    }


    public function getAll($conditions)
    {
        return Element::all();

    }

    public function getAllInFloor($floorId,$conditions)
    {
        return Element::where('floor_id',$floorId)->get();

    }

    public function getAllInFloorWithTitle($floorId,$conditions)
    {

        $languageId = isset($languageId) ? $languageId : Language::getCurrentLanguage()->id;

        $elements = \App\Models\Element::with(['fields' => function($query) use ($languageId) {
            $query->where('language_id', $languageId)
                  ->where('name', 'title');
        }])
        ->where('floor_id',$floorId)
        ->get()
        ->map(function ($element) {
            // Mapea los resultados para agregar el campo "title" desde los FloorFields
            $titleField = $element->fields->first();
            $element->title = $titleField ? $titleField->value : null;
            return $element;
        });

        return $elements;

    }


}
