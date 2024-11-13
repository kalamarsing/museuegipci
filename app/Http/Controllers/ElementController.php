<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Repositories\ElementRepository;


use App\Http\Controllers\Controller;
use App\Models\Element;
use App\Models\ElementField;

use App\Models\Floor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;

class ElementController extends Controller
{
    public function __construct(ElementRepository $elements) {
        $this->elements = $elements;
    }

    public function get($elementId, Request $request)
    {

        return response()->json($this->elements->findById($elementId));
      
    }


    public function getAll(Request $request)
    {

        return response()->json($this->elements->getAll($request->all()));

    }

    public function getAllInFloor($floorId, Request $request)
    {

        return response()->json($this->elements->getAllInFloor($floorId, $request->all()));

    }
    public function getAllInFloorWithTitle($floorId, Request $request)
    {

        return response()->json($this->elements->getAllInFloorWithTitle($floorId, $request->all()));

    }


    

    public function index(Request $request): View
    {
        return view('backend.element.index',[
            'elements' => $this->elements->getAll($request->all())
        ]);
    }


    public function indexInFloor ($floorId ,Request $request): View
    {
        $pointers = [];

        $floor = Floor::with('elements')->where('id', $floorId)->first();
        $pointers = $floor->elements->map(function ($element) use ($floor) {
            return [
                'latitude' => $element->latitude,
                'longitude' => $element->longitude,
                'number' => $element->number,
                'url' => "/admin/floor/{$floor->id}/element/{$element->id}",
                'title' => $element->getFieldValue('title'),
                'subtitle' => $element->getFieldValue('subtitle'),
                'permanentExposition' =>  $element->permanent_exposition
            ];
        })->toArray();


        return view('backend.element.index',[
            'elements' => $this->elements->getAllInFloor($floorId, $request->all()),
            'floor' => Floor::where('id',$floorId)->first(),
            'pointers' => $pointers
        ]);
    }


    public function create($floorId, Request $request)
    {
        return  view('backend.element.form', [
            'floor' => Floor::where('id',$floorId)->first()
        ]);
    }

    public function show($floorId, $elementId, Request $request)
    {
        $success = true;
        $message = '';
        try{
            $element = $this->elements->findById($elementId);
            $fields = $element->getLocalizedFields();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $success = false;
        }

        return  view('backend.element.form',[
            'floor' => Floor::where('id',$floorId)->first(),
            'fields' => $fields,
            'element' => $element,
            'success' => $success,
            'message' => $message
        ]);

    }

    public function store(Request $request)
    {

        try {
            $element = Element::create([
                'permanent_exposition' => $request->permanent_exposition,
                'audio_image' => $request->audio_image,
                'video_image' => $request->video_image,
                'number' => $request->number,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'floor_id' => $request->floor_id,
            ]);
    
            // Guardar los títulos en varios idiomas
            foreach ($request->title as $languageId => $value) {
                ElementField::updateOrCreate(
                    ['element_id' => $element->id, 'language_id' => $languageId, 'name' => 'title'],
                    ['value' => $value]
                );
            }

            // Guardar los subtítulos en varios idiomas
            foreach ($request->subtitle as $languageId => $value) {
                ElementField::updateOrCreate(
                    ['element_id' => $element->id, 'language_id' => $languageId, 'name' => 'subtitle'],
                    ['value' => $value]
                );
            }

            // Guardar los títulos en varios idiomas
            foreach ($request->text as $languageId => $value) {
                ElementField::updateOrCreate(
                    ['element_id' => $element->id, 'language_id' => $languageId, 'name' => 'text'],
                    ['value' => $value]
                );
            }

            // Guardar los títulos en varios idiomas
            foreach ($request->audio as $languageId => $value) {
                ElementField::updateOrCreate(
                    ['element_id' => $element->id, 'language_id' => $languageId, 'name' => 'audio'],
                    ['value' => $value]
                );
            }

            // Guardar los títulos en varios idiomas
            foreach ($request->video as $languageId => $value) {
                ElementField::updateOrCreate(
                    ['element_id' => $element->id, 'language_id' => $languageId, 'name' => 'video'],
                    ['value' => $value]
                );
            }
    
            return response()->json([
                'element' => $element,
                'success' => true
            ]);
    
        } catch (\Exception $e) {
            dd($e);
            $message = $e->getMessage();
    
            return response()->json([
                'success' => false,
                'message' => $message
            ]);
        }

    }


    public function update(Request $request, $id)
    {
        
        try {
            $element = Element::findOrFail($id);
    
            $element->permanent_exposition= $request->permanent_exposition;
            $element->audio_image= $request->audio_image;
            $element->video_image= $request->video_image;

            $element->number= $request->number;
            $element->latitude= $request->latitude;
            $element->longitude= $request->longitude;
            $element->floor_id= $request->floor_id;
            $element->save();

             // Guardar los títulos en varios idiomas
             foreach ($request->title as $languageId => $value) {
                ElementField::updateOrCreate(
                    ['element_id' => $element->id, 'language_id' => $languageId, 'name' => 'title'],
                    ['value' => $value]
                );
                
            }

             // Guardar los subtítulos en varios idiomas
             foreach ($request->subtitle as $languageId => $value) {
                ElementField::updateOrCreate(
                    ['element_id' => $element->id, 'language_id' => $languageId, 'name' => 'subtitle'],
                    ['value' => $value]
                );
                
            }

              // Guardar los títulos en varios idiomas
              foreach ($request->text as $languageId => $value) {
                    ElementField::updateOrCreate(
                        ['element_id' => $element->id, 'language_id' => $languageId, 'name' => 'text'],
                        ['value' => $value]
                    );
                }

                // Guardar los títulos en varios idiomas
                foreach ($request->audio as $languageId => $value) {
                    ElementField::updateOrCreate(
                        ['element_id' => $element->id, 'language_id' => $languageId, 'name' => 'audio'],
                        ['value' => $value]
                    );
                }

                            // Guardar los títulos en varios idiomas
                foreach ($request->video as $languageId => $value) {
                    ElementField::updateOrCreate(
                        ['element_id' => $element->id, 'language_id' => $languageId, 'name' => 'video'],
                        ['value' => $value]
                    );
                }

    
            return response()->json([
                'element' => $element,
                'success' => true
            ]);
    
        } catch (\Exception $e) {
            $message = $e->getMessage();
    
            return response()->json([
                'success' => false,
                'message' => $message
            ]);
        }
    
    }

    /**
     * Delete the element's account.
     */
    public function delete( Request $request, $id)
    {

        $element = $this->elements->findById($id);
        $floorId = $element->floor_id;
        $element->delete();

        return Redirect::to('/admin/elements/'.$floorId.'/index');

    }


  
}
