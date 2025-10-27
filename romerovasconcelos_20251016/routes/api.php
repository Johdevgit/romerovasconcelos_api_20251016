<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ZonaController;

// Para obtener detalles del usuario mediante el token recibido al hacer login
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/zonas',[ZonaController::class,'obtenerZonas']); //Plural

Route::get('/zona/{idzona}',[ZonaController::class,'obtenerZona']); //Singular

Route::get('/zonaspais/{idpais}',[ZonaController::class,'obtenerZonaPais']);

Route::post('/nuevazona',[ZonaController::class,'crearZona']);


Route::controller(RegisterController::class)->group(function(){
    Route::post('/register', 'register');
    Route::post('/login','login');
});
