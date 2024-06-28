<?php

namespace App\Http\Controllers\Api;

use App\Models\Usuario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * La clase controller se encarga de manejar las operaciones
 * relacionadas con los usuarios en la API Rest.
 * 
 * A continuación se describe el funcionamiento de los 
 * métodos básicos de el CRUD (create-read-update-delete)
 */
class usuarioController extends Controller {

    // La función listar obtiene todos los registros 
    //  de usuarios almacenados en la base de datos.
    public function listar() {

        // A la variable $usuarios le es asignado el resultado 
        //  de la consulta all() a la tabla 'usuarios' (definida en la entidad Usuario.php)
        $usuarios = Usuario::all();

        /*Se crea y devuelve un arreglo con el resultado de la consulta y el status*/
        $data = [
            'usuarios' => $usuarios,
            'status' => 200
        ];

        return response()->json($data, 200);

    }

    /*
    La función save recibe una carga útil (generalmente en formato json)
     la cual debe contener los parametros requeridos por la entidad Usuario.php
      para poder crear y guardar un usuario en base de datos 
    */
    public function save(Request $request) {

        /*
        La clase Validator permite verificar que los datos ingresados 
         por el usuario sean válidos. En este caso, todos los parámetros 
          son obligatorios.
        */
        $validator = Validator::make($request->all(), [
            'usuario' => 'required',
            'contraseña' => 'required',
            'email' => 'required',
        ]);

        /*
        Si no se aprueban las validaciones se retorna al usuario
         un mensaje especificando los errores en los campos.
        */
        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        /*
        Si los parametros ingresados son correctos, se ejecuta la consulta
         create en la tabla 'usuarios' (definida en la entidad Usuario.php)
        */
        $usuario = Usuario::create([
            'usuario' => $request->usuario,
            'contraseña' => $request->contraseña,
            'email' => $request->email,
        ]);

        /*
        Si ocurre un error de conexión o cualquier otro inconveniente al 
         intentar crear el usuario se devuelve un error al cliente, de lo
          contrario se muestran los parámetros ingresados y un status 201 Creado
           el cual indica que una solicitud POST ha tenido éxito.
        */
        if (!$usuario) {
            $data = [
                'message' => 'Error al crear estudiante',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'student' => $usuario,
            'status' => 201
        ];

        return response()->json($data, 201);

        
    }

    /*
    La función actualizar se encarga de actualizar los datos 
     de un usuario y devuelve una respuesta en formato JSON 
      que indica el resultado de la operación. 
       En este caso, además de la carga útil tambien se requiere
        especificar el id del usuario a modificar en la url de la petición.
    */
    public function actualizar(Request $request, $id) {
        
        /*
        Se ejecuta la busqueda de usuario según el id 
         especificado en la petición
        */
        $usuario = Usuario::find($id);

        if (!$usuario) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        
        //Se validan los parametros de la carga útil o body
        $validator = Validator::make($request->all(), [
            'usuario' => 'required',
            'contraseña' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        /*
        Si los parametros recibidos son válidos se asignan al usuario
         especificado en el id.
        */
        $usuario->usuario = $request->usuario;
        $usuario->contraseña = $request->contraseña;
        $usuario->email = $request->email;
        $usuario->save();

        $data = [
            'message' => 'Usuario actualizado',
            'usuario' => $usuario,
            'status' => 200
        ];

        return response()->json($data, 200);

    }

    /*
    La función eliminar recibe el id parametro en la 
     url de la solicitud, si el usuario existe es eliminado
      de la tabla.
    */
    public function eliminar($id) {

        $usuario = Usuario::find($id);

        if (!$usuario) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        
        $usuario->delete();

            $data = [
                'message' => 'Usuario eliminado',
                'status' => 200
            ];
        
        return response()->json($data, 200);

    }


}
