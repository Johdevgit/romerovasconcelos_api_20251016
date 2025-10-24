<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zona;

class ZonaController extends Controller
{
    //

    public function obtenerZonas(){
        $Zona = new Zona();

        $satisfactorio = false;
        $estado = 0;
        $mensaje = "";
        $errores = [];
        $valores = [];

        $valores = $Zona::all();

        // Verificacion de existencia de datos
        if(!empty($valores)){
            $satisfactorio = true;
            $estado = 200;
            $mensaje = "Valores encontrados";
            $errores = [
                "code" => 200,
                "msg" => ""
            ];
        }else{
        // No se encontraron datos
            $satisfactorio = false;
            $estado = 404;
            $mensaje = "No se han encontrado valores";
            $errores = [
                "code" => 404,
                "msg" => "Datos no encontrados"
            ];
        }

        // Se crea la variable de salida
        $respuesta = [
            "success" => $satisfactorio,
            "status" => $estado,
            "msg" => $mensaje,
            "data" => $valores,
            "errors" => $errores,
            "total" => sizeof($valores)
        ];

        // Se retorna el mensaje al usuario
        return response()->json($respuesta,$estado);
    }

    public function obtenerZona(int $idzona = 0){

        $satisfactorio = false;
        $estado = 0;
        $mensaje = "";
        $errores = [];
        $valores = [];

        if($idzona > 0){

            $Zona = new Zona();
            $valores = $Zona->where('id_zona', $idzona)->get();

            // Verificacion de existencia de datos
            if(!empty($valores)){
                // Si se encontraron datos
                $satisfactorio = true;
                $estado = 200;
                $mensaje = "Valores encontrados";
                $errores = [
                    "code" => 200,
                    "msg" => ""
                ];
            }else{
            // No se encontraron datos
                $satisfactorio = false;
                $estado = 404;
                $mensaje = "No se han encontrado valores";
                $errores = [
                    "code" => 404,
                    "msg" => "Datos no encontrados"
                ];
            } // Fin del if(!empty($valores)){

        }else{
            // El parametro de idzona no es mayor que 0
            // No se ha enviado un valor para el parametro $idzona

            $satisfactorio = false;
            $estado = 400;
            $mensaje = "No se ha enviado el parametro obligatorio";
            $errores = [
                "code" => 400,
                "msg" => "El identificador de la zona esta vacio"
            ];

        } // Fin del if($idzona > 0){

        // Se crea la variable de salida
        $respuesta = [
            "success" => $satisfactorio,
            "status" => $estado,
            "msg" => $mensaje,
            "data" => $valores,
            "errors" => $errores,
            "total" => sizeof($valores)
        ];
    
        // Se retorna el mensaje al usuario
        return response()->json($respuesta,$estado);
    }

    public function obtenerZonaPais(int $idpais = 0){

        $satisfactorio = false;
        $estado = 0;
        $mensaje = "";
        $errores = [];
        $valores = [];

        if($idpais > 0){

            $Zona = new Zona();
            $valores = $Zona->where('id_pais', $idpais)->get();

            // Verificacion de existencia de datos
            if(!empty($valores)){
                // Si se encontraron datos
                $satisfactorio = true;
                $estado = 200;
                $mensaje = "Valores encontrados";
                $errores = [
                    "code" => 200,
                    "msg" => ""
                ];
            }else{
            // No se encontraron datos
                $satisfactorio = false;
                $estado = 404;
                $mensaje = "No se han encontrado valores";
                $errores = [
                    "code" => 404,
                    "msg" => "Datos no encontrados"
                ];
            } // Fin del if(!empty($valores)){

        }else{
            // El parametro de idpais no es mayor que 0
            // No se ha enviado un valor para el parametro $idpais

            $satisfactorio = false;
            $estado = 400;
            $mensaje = "No se ha enviado el parametro obligatorio";
            $errores = [
                "code" => 400,
                "msg" => "El identificador del pais esta vacio"
            ];

        } // Fin del if($idpais > 0){

        // Se crea la variable de salida
        $respuesta = [
            "success" => $satisfactorio,
            "status" => $estado,
            "msg" => $mensaje,
            "data" => $valores,
            "errors" => $errores,
            "total" => sizeof($valores)
        ];
    
        // Se retorna el mensaje al usuario
        return response()->json($respuesta,$estado);
    }

    public function crearZona(Request $request){

        $satisfactorio = false;
        $estado = 0;
        $mensaje = "";
        $errores = [];
        $valores = [];

        // Validacion de datos de entrada en los parametros
        $validacion = $request->validate([
            "idpais" => "required|integer|gt:0",
            "nombrezona" => "required|max:50"
        ]);

        $Zona = new Zona();

        // Se asignan a cada atributo de la tabla los campos del formulario
        $Zona->id_pais = $request->idpais;
        //------^(campo de BD) ------------^(Campo de form)
        $Zona->nombre_zona = $request->nombrezona;
        //---------^(campos de BD) --------------^(Campo de forma)

        $insertado = $Zona->save(); // Se hace insert a la base de datos

        if($insertado){

            $ultimoinsertado = $Zona->id_zona;
            $datosinsertados = $this->obtenerZona($ultimoinsertado);
            
            $satisfactorio = true;
            $estado = 200;
            $mensaje = "Se guardaron los datos correctamente";
            $errores = [
                "code" => 200,
                "msg" => ""
            ];

        }else{
            $satisfactorio = false;
            $estado = 500;
            $mensaje = "Hubo un problema al guardar los datos";
            $errores = [
                "code" => 500,
                "msg" => "No se pudo hacer insert a la tabla Zona"
            ];
        }

        // Se crea la variable de salida
        $respuesta = [
            "success" => $satisfactorio,
            "status" => $estado,
            "msg" => $mensaje,
            "data" => $datosinsertados->original["data"][0],
            "errors" => $errores,
            "total" => $datosinsertados->original["total"]
            //"total" => sizeof($valores)
        ];
    
        // Se retorna el mensaje al usuario
        return response()->json($respuesta,$estado);

    }

}
