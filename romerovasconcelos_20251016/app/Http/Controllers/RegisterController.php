<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{

     public function register(Request $request): JsonResponse
     {

        // Mensajes personalizados de error
        $messages = [
            'name.required' => 'El nombre es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 4 caracteres.',
            'name.max' => 'El nombre no debe superar los 100 caracteres.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El formato del correo no es válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'email.max' => 'El correo no debe superar los 100 caracteres.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max' => 'La contraseña no debe superar los 20 caracteres.',
            'c_password.required' => 'La confirmación de la contraseña es obligatoria.',
            'c_password.same' => 'Las contraseñas no coinciden.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|max:100',
            'email'=> 'required|email|unique:users,email|max:100',
            'password'=> 'required|min:8|max:20',
            'c_password'=>'required|same:password'
            
        ],$messages);

        if ($validator->fails()){
            return $this->enviarError('Error de validación', $validator->errors(), 200);
            
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('Prueba')->plainTextToken;
        $success['name'] = $user->name;

        return $this->enviarRespuesta($success, 'Usuario registrado con éxito');

     }

     public function login(Request $request): JsonResponse{

        // Verificacion de usuario
        $user = User::where('email', $request->email)->first();

        // Si el usuario no existe se retorna un error generico para evitar problemas de seguridad
        if (!$user) {
            return $this->enviarError('No autorizado', ['error' => 'Credenciales equivocadas'], 401);
        }

        // Autentificacion de usuario
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] = $user->createToken('Prueba')->plainTextToken;
            $success['name'] = $user->name;

            return $this->enviarRespuesta($success,'Inicio de sesión exitoso');

        }else{
            return $this->enviarError('No autorizado', ['error' => 'Credenciales incorrectas'], 401);
        }

     }
}
