<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Repositories\CodeRepository;


use App\Http\Controllers\Controller;
use App\Models\Code;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use App;

class CodeController extends Controller
{
    public function __construct(CodeRepository $codes) {
        $this->codes = $codes;
    }

    public function get($codeId, Request $request)
    {

        return response()->json($this->codes->findById($codeId));
      
    }


    public function getAll(Request $request)
    {

        return response()->json($this->codes->getAll($request->all()));

    }

    public function index(Request $request): View
    {
        return view('backend.code.index',[
            'codes' => $this->codes->getAll($request->all())
        ]);
    }

    public function create(Request $request)
    {
        return  view('backend.code.form');
    }

    public function show($codeId, Request $request)
    {
        $success = true;
        $message = '';
        try{
            $code = $this->codes->findById($codeId);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $success = false;
        }

        return  view('backend.code.form',[
            'code' => $code,
            'success' => $success,
            'message' => $message
        ]);
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'value' => ['required', 'string', 'max:255'],
            ]);

            $code = Code::create([
                'value' => $request->value,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura los errores de validación y devuelve una respuesta JSON con los errores.
            return response()->json([
                'success' => false,
                'message' => $e->errors() // Devuelve todos los errores de validación
            ], 422);

        } catch (\Exception $e) {
            $message = $e->getMessage();

            return response()->json([
                'success' => false,
                'message' => $message
            ]);

        }

        return response()->json([
            'code' => $code,
            'success' => true
        ]);

    }


    public function update(Request $request, $id)
    {
        try{
            $code = $this->codes->findById($id);
            $code->value = $request->value;
            $code->save();

        } catch (\Exception $e) {
            $message = $e->getMessage();

            return response()->json([
                'success' => false,
                'message' => $message
            ]);

        }

        return response()->json([
            'code' => $code,
            'success' => true
        ]);
    
    }

    /**
     * Delete the code's account.
     */
    public function delete(Request $request, $id)
    {

        $code = $this->codes->findById($id);
        
        $code->delete();

        return Redirect::to('/admin/codes');
    }


    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string', // Validar el código según tu lógica
        ]);
        
        try {
            $this->codes->findByValue($request->code); // Suponiendo que `$codeId` es el código introducido
        } catch (\Exception $e) {
            // Redirigir de nuevo con un mensaje de error
            return back()->withErrors(['code' => get_dinamic_field_value('enter-code.incorrect.text') ])->withInput();
        }
    
        // Guardar el código en la sesión por 4 horas
        session()->put('access_code', $request->code, now()->addHours(4));
    
        // Redirigir a la página de inicio o protegida
        return redirect()->route('front.home',['locale' => App::getLocale()]);
        
    }


    public function clearSessionCode()
    {
        // Eliminar el código y su expiración de la sesión
        session()->forget(['access_code']);

        // Opcional: Redirigir a una página o a la página de inicio
        return redirect()->route('front.code');
    }
  
}
