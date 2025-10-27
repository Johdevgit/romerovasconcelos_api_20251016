<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function enviarRespuesta($resultado, $mensaje){
        $respuesta = [
            'satisfactorio'=> true,
            'data'=> $resultado,
            'mensaje'=> $mensaje
        ];

        return response()->json($respuesta,200);
    }

    public function enviarError($error, $mensajeError = [], $codigoestado){
        $respuesta = [
            'satisfactorio'=> false,
            'mensaje'=> $error
        ];

        if(!empty($mensajeError)){
            $respuesta['data'] = $mensajeError;
        }

        return response()->json($respuesta, $codigoestado);
    
    }

}