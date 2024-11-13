<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Repositories\UserRepository;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    public function __construct(UserRepository $users) {
        $this->users = $users;
    }

    public function get($userId, Request $request)
    {

        return response()->json($this->users->findById($userId));
      
    }


    public function getAll(Request $request)
    {

        return response()->json($this->users->getAll($request->all()));

    }

    public function index(Request $request): View
    {
        return view('backend.user.index',[
            'users' => $this->users->getAll($request->all())
        ]);
    }

    public function create(Request $request)
    {
        return  view('backend.user.form');
    }

    public function show($userId, Request $request)
    {
        $success = true;
        $message = '';
        try{
            $user = $this->users->findById($userId);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $success = false;
        }

        return  view('backend.user.form',[
            'user' => $user,
            'success' => $success,
            'message' => $message
        ]);
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

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
            'user' => $user,
            'success' => true
        ]);

    }


    public function update(Request $request, $id)
    {
        try{
            $user = $this->users->findById($id);

            $user->name = $request->name;
            $user->email = $request->email;

            // Solo actualiza la contraseña si se proporciona una nueva
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            $user->save();
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return response()->json([
                'success' => false,
                'message' => $message
            ]);

        }

        return response()->json([
            'user' => $user,
            'success' => true
        ]);
    
    }

    /**
     * Delete the user's account.
     */
    public function delete(Request $request, $id)
    {

        $user = $this->users->findById($id);
        
        $myUser = false;
        if($user->id == Auth::user()->id){
           $myUser = true;
           Auth::logout();
        }

        $user->delete();

        if($myUser){
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/');
        }else{
            return Redirect::to('/admin/users');
        }
    }


  
}
