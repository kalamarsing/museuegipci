<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Language;
use App\Models\Floor;
use App\Repositories\FloorRepository;
use App\Repositories\ElementRepository;

class FrontController extends Controller
{
   
    public function __construct(FloorRepository $floors, ElementRepository $elements) {
        $this->elements = $elements;
        $this->floors = $floors;
    }

    public function languages(Request $request): View
    {
        $languages = Language::all();

        return view('front.languages', [
                'languages' => $languages
            ]
        );
    }

    public function code($lang, Request $request): View
    {
        return view('front.code');
    }

    //private part
    public function home(Request $request): View
    {
        return view('front.home');
    }

    public function cookies($lang, Request $request): View
    {
        return view('front.cookies');
    }

    public function avis($lang, Request $request): View
    {
        return view('front.avis');
    }

    public function  museu($lang, Request $request): View
    {
        $floors = $this->floors->getAllWithTitle($request->all());
        
        return view('front.museu', 
            [
             'floors' => $floors
            ]
        );
    }

    public function  floor($lang, $floorId, Request $request): View
    {
        $floor = $this->floors->findById($floorId);

        $pointers = [];
      //  $floor = Floor::with('elements')->where('id', $floorId)->first();

        $pointers = $floor->elements->map(function ($element) use ($floor, $lang) {
            return [
                'latitude' => $element->latitude,
                'longitude' => $element->longitude,
                'number' => $element->number,
                'title' => $element->getFieldValue('title'),
                'subtitle' => $element->getFieldValue('subtitle'),
                'url' => "/{$lang}/element/{$element->id}",
                'permanentExposition' =>  $element->permanent_exposition
            ];
        })->toArray();
        

        $hasPermanentPointers = $floor->elements()->where('permanent_exposition', 1)->exists();
        
        if(!$hasPermanentPointers) {
            return view('front.floor',[
                    'floor' => $floor,
                    'pointers' => $pointers
                ]
            );
        }

        $permanentPointers = $floor->elements()->where('permanent_exposition', 1)->get()->map(function ($element) use ($floor, $lang) {
            return [
                'latitude' => $element->latitude,
                'longitude' => $element->longitude,
                'number' => $element->number,
                'title' => $element->getFieldValue('title'),
                'subtitle' => $element->getFieldValue('subtitle'),
                'url' => "/{$lang}/element/{$element->id}",
                'permanentExposition' =>  $element->permanent_exposition
            ];
        })->toArray();

        $temporalPointers = $floor->elements()->where('permanent_exposition', 0)->get()->map(function ($element) use ($floor,  $lang) {
            return [
                'latitude' => $element->latitude,
                'longitude' => $element->longitude,
                'number' => $element->number,
                'title' => $element->getFieldValue('title'),
                'subtitle' => $element->getFieldValue('subtitle'),
                'url' => "/{$lang}/element/{$element->id}",
                'permanentExposition' =>  $element->permanent_exposition
            ];
        })->toArray();

        return view('front.floor-permanent',[
                'floor' => $floor,
                'pointers' => $pointers,
                'permanentPointers' => $permanentPointers,
                'temporalPointers' => $temporalPointers
            ]
        );
        
       
    }


    public function  element($lang, $elementId, Request $request): View
    {
        $element = $this->elements->findById($elementId);

        return view('front.element',[
               'element' => $element
            ]
        );
        
       
    }

    public function  video($lang, $elementId, Request $request): View
    {
        $element = $this->elements->findById($elementId);

        return view('front.video',[
               'element' => $element
            ]
        );
        
       
    }

}
