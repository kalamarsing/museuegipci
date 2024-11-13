<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Repositories\LanguageRepository;


use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;

class LanguageController extends Controller
{
    public function __construct(LanguageRepository $languages) {
        $this->languages = $languages;
    }

    public function get($languageId, Request $request)
    {

        return response()->json($this->languages->findById($languageId));
      
    }


    public function getAll(Request $request)
    {

        return response()->json($this->languages->getAll($request->all()));

    }

    public function index(Request $request): View
    {
        return view('backend.language.index',[
            'languages' => $this->languages->getAll($request->all())
        ]);
    }

    public function create(Request $request)
    {
        return  view('backend.language.form');
    }

    public function show($languageId, Request $request)
    {
        $success = true;
        $message = '';
        try{
            $language = $this->languages->findById($languageId);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $success = false;
        }

        return  view('backend.language.form',[
            'language' => $language,
            'success' => $success,
            'message' => $message
        ]);
    }

    public function store(Request $request)
    {
        try{

            $language = Language::create([
                'name' => $request->name,
                'iso' => $request->iso,
                'isDefault' => $request->isDefault
            ]);

        } catch (\Exception $e) {
            $message = $e->getMessage();

            return response()->json([
                'success' => false,
                'message' => $message
            ]);

        }

        return response()->json([
            'language' => $language,
            'success' => true
        ]);

    }


    public function update(Request $request, $id)
    {
        try{
            $language = $this->languages->findById($id);

            $language->name = $request->name;
            $language->iso = $request->iso;
            $language->isDefault = $request->isDefault;

            $language->save();
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return response()->json([
                'success' => false,
                'message' => $message
            ]);

        }

        return response()->json([
            'language' => $language,
            'success' => true
        ]);
    
    }

    /**
     * Delete the language's account.
     */
    public function delete(Request $request, $id)
    {

        $language = $this->languages->findById($id);
        $language->delete();

        return Redirect::to('/admin/languages');

    }


  
}
