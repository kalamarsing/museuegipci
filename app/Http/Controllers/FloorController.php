<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Repositories\FloorRepository;


use App\Http\Controllers\Controller;
use App\Models\Floor;
use App\Models\FloorField;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;

class FloorController extends Controller
{
    public function __construct(FloorRepository $floors) {
        $this->floors = $floors;
    }

    public function get($floorId, Request $request)
    {

        return response()->json($this->floors->findById($floorId));
      
    }


    public function getAll(Request $request)
    {

        return response()->json($this->floors->getAll($request->all()));

    }

    public function getAllWithTitle(Request $request)
    {

        return response()->json($this->floors->getAllWithTitle($request->all()));

    }

    public function index(Request $request): View
    {
        return view('backend.floor.index',[
            'floors' => $this->floors->getAll($request->all())
        ]);
    }

    public function create(Request $request)
    {
        return  view('backend.floor.form');
    }

    public function show($floorId, Request $request)
    {
        $success = true;
        $message = '';
        try{
            $floor = $this->floors->findById($floorId);
            $fields = $floor->getLocalizedFields();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $success = false;
        }
        
        return  view('backend.floor.form',[
            'floor' => $floor,
            'fields' => $fields,
            'success' => $success,
            'message' => $message
        ]);
    }

    public function store(Request $request)
    {
        try {
            $floor = Floor::create([
                'map' => $request->map,
                'map2'=> $request->map2,
                'image' => $request->image,
                'order' => $request->order
            ]);
    
            // Guardar los títulos en varios idiomas
            foreach ($request->title as $languageId => $value) {
                FloorField::updateOrCreate(
                    ['floor_id' => $floor->id, 'language_id' => $languageId, 'name' => 'title'],
                    ['value' => $value]
                );
            }
    
            return response()->json([
                'floor' => $floor,
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


    public function update(Request $request, $id)
    {

        try {
            $floor = Floor::findOrFail($id);
    
            $floor->map = $request->map;
            $floor->map2 = $request->map2;
            $floor->image = $request->image;
            $floor->order = $request->order;
            $floor->save();
    
            // Actualizar los títulos en varios idiomas
            foreach ($request->title as $languageId => $value) {
                FloorField::updateOrCreate(
                    ['floor_id' => $floor->id, 'language_id' => $languageId, 'name' => 'title'],
                    ['value' => $value]
                );
            }
    
            return response()->json([
                'floor' => $floor,
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
     * Delete the floor's account.
     */
    public function delete(Request $request, $id)
    {

        $floor = Floor::findOrFail($id);
        $floor->delete();

        // Eliminar también los campos asociados
        FloorField::where('floor_id', $id)->delete();

        return Redirect::to('/admin/floors');
        
    }


  
}
