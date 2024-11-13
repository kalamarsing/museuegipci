<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\ElementController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\MediaController;

use App\Http\Middleware\EnsureEnterCodeIsCorrect;
use App\Http\Middleware\SetLocale;


Route::get('/', [FrontController::class, 'languages'])->name('front.languages');


Route::group(['prefix' => '{locale}', 'middleware' => [ SetLocale::class]], function () {    
    Route::get('/enter-code',[FrontController::class, 'code'])->name('front.code');
    Route::post('/verify-code', [CodeController::class, 'verify'])->name('verify.code');
});


//code routes
Route::get('/clear-code', [CodeController::class, 'clearSessionCode'])->name('clear.code');

//RUTAS EL BACKEND VA ENCAPSULADO EN AUTH PQ NECESITA LOGIN
Route::middleware('auth')->prefix('admin')->group(function () {
    //Users
    Route::get('/users/all', [UserController::class, 'getAll'])->name('user.getAll');
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'delete'])->name('user.delete');


    //Code
    Route::get('/codes/all', [CodeController::class, 'getAll'])->name('code.getAll');
    Route::get('/codes', [CodeController::class, 'index'])->name('code.index');
    Route::get('/code/{id}', [CodeController::class, 'show'])->name('code.show');
    Route::get('/code', [CodeController::class, 'create'])->name('code.create');
    Route::post('/code', [CodeController::class, 'store'])->name('code.store');
    Route::put('/code/{id}', [CodeController::class, 'update'])->name('code.update');
    Route::delete('/code/{id}', [CodeController::class, 'delete'])->name('code.delete');


    //Languages
    Route::get('/languages/all', [LanguageController::class, 'getAll'])->name('language.getAll');
    Route::get('/languages', [LanguageController::class, 'index'])->name('language.index');
    Route::get('/language/{id}', [LanguageController::class, 'show'])->name('language.show');
    Route::get('/language', [LanguageController::class, 'create'])->name('language.create');
    Route::post('/language', [LanguageController::class, 'store'])->name('language.store');
    Route::put('/language/{id}', [LanguageController::class, 'update'])->name('language.update');
    Route::delete('/language/{id}', [LanguageController::class, 'delete'])->name('language.delete');


    //Pages
    Route::get('/pages/all', [PageController::class, 'getAll'])->name('page.getAll');
    Route::get('/pages', [PageController::class, 'index'])->name('page.index');
    Route::get('/page/{id}', [PageController::class, 'show'])->name('page.show');
    Route::get('/page', [PageController::class, 'create'])->name('page.create');
    Route::post('/page', [PageController::class, 'store'])->name('page.store');
    Route::put('/page/{id}', [PageController::class, 'update'])->name('page.update');
    Route::delete('/page/{id}', [PageController::class, 'delete'])->name('page.delete');

    //Floors
    Route::get('/floors/all', [FloorController::class, 'getAll'])->name('floor.getAll');
    Route::get('/floors/all/title', [FloorController::class, 'getAllWithTitle'])->name('floor.getAllWithTitle');

    Route::get('/floors', [FloorController::class, 'index'])->name('floor.index');
    Route::get('/floor/{id}', [FloorController::class, 'show'])->name('floor.show');
    Route::get('/floor', [FloorController::class, 'create'])->name('floor.create');
    Route::post('/floor', [FloorController::class, 'store'])->name('floor.store');
    Route::put('/floor/{id}', [FloorController::class, 'update'])->name('floor.update');
    Route::delete('/floor/{id}', [FloorController::class, 'delete'])->name('floor.delete');
  

    //Elements
    Route::get('/elements/all', [ElementController::class, 'getAll'])->name('element.getAll');
    Route::get('/elements/{floorId}/all', [ElementController::class, 'getAllInFloor'])->name('element.getAllInFloor');
    Route::get('/elements/{floorId}/all/title', [ElementController::class, 'getAllInFloorWithTitle'])->name('element.getAllInFloorWithTitle');

    
    Route::get('/elements', [ElementController::class, 'index'])->name('element.index');
    Route::get('/elements/{floorId}/index', [ElementController::class, 'indexInFloor'])->name('element.floor.index');

    Route::get('floor/{floorId}/element/{id}', [ElementController::class, 'show'])->name('element.show');
    Route::get('floor/{floorId}/element/', [ElementController::class, 'create'])->name('element.create');
    Route::post('/element', [ElementController::class, 'store'])->name('element.store');
    Route::put('/element/{id}', [ElementController::class, 'update'])->name('element.update');
    Route::delete('/element/{id}', [ElementController::class, 'delete'])->name('element.delete');

    //Medias
    Route::post('/media/upload', [MediaController::class, 'upload'])->name('media.upload');


    Route::get('/dashboard', function () {
        return view('backend.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   
});


//RUTAS EL FRONTEND EXCEPTO LA PAGINA DE CODIGO VA ENCAPSULADO EN EL MIDDLEWARE EnsureEnterCodeISCorrect por el codigo


//Route::middleware([EnsureEnterCodeIsCorrect::class])->group(function () {
Route::group(['prefix' => '{locale}', 'middleware' => [EnsureEnterCodeIsCorrect::class, SetLocale::class]], function () {


    Route::get('/home', [FrontController::class, 'home'])->name('front.home');
    Route::get('/cookies', [FrontController::class, 'cookies'])->name('front.cookies');
    Route::get('/avis-legal', [FrontController::class, 'avis'])->name('front.avis');

    Route::get('/museu', [FrontController::class, 'museu'])->name('front.museu');
    Route::get('/floor/{floorId}', [FrontController::class, 'floor'])->name('front.floor');
    Route::get('/element/{elementId}', [FrontController::class, 'element'])->name('front.element');
    Route::get('/video/{elementId}', [FrontController::class, 'video'])->name('front.video');


});


require __DIR__.'/auth.php';
