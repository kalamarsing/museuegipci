<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

use App\Models\Floor;
use App\Models\Language;

use Illuminate\Http\Request;
use App\Traits\PaginateWithFormat;
use App\Traits\AddOperationsToQuery;


class FloorRepository extends BaseRepository
{
    use PaginateWithFormat;
    use AddOperationsToQuery;

    public function __construct()
    {
    }

    public function model()
    {
        return "App\\Models\\Floor";
    }

    public function findById($floorId)
    {
        // Obtener el floor actual con sus relaciones
        $floor = Floor::with('fields','elements')->where('id', $floorId)->first();
    
        if (!$floor) {
            throw new \Exception('No floor found', 404);
        }
    
        // Obtener el floor anterior basándonos en el campo 'order'
        $prev = Floor::where('order', '<', $floor->order)
                     ->orderBy('order', 'desc')
                     ->first();
    
        // Obtener el floor siguiente basándonos en el campo 'order'
        $next = Floor::where('order', '>', $floor->order)
                     ->orderBy('order', 'asc')
                     ->first();
    
        // Añadir prev y next como propiedades al objeto floor
        $floor->prev = $prev;
        $floor->next = $next;
    
        // Retornar el objeto floor con prev y next incluidos
        return $floor;
    }
    

    public function getAll($conditions)
    {
        return Floor::orderBy('order', 'asc')->get();

    }


    public function getAllWithTitle($conditions)
    {
        $languageId = isset($languageId) ? $languageId : Language::getCurrentLanguage()->id;

        $floors = \App\Models\Floor::with(['fields' => function($query) use ($languageId) {
            $query->where('language_id', $languageId)
                  ->where('name', 'title');
        }])
        ->orderBy('order', 'asc')
        ->get()
        ->map(function ($floor) {
            // Mapea los resultados para agregar el campo "title" desde los FloorFields
            $titleField = $floor->fields->first();
            $floor->title = $titleField ? $titleField->value : null;
            return $floor;
        });

        return $floors;

    }

}
