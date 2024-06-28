<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * la clase Usuario es un modelo de datos en Laravel que 
 * representa una tabla en la base de datos. 
 * La clase utiliza la clase Model de Laravel y proporciona 
 * una forma de interactuar con la base de datos.
 */
class Usuario extends Model {
    use HasFactory;

    /*
    La propiedad $table indica el nombre de la tabla en la 
     base de datos que se va a utilizar para almacenar los 
      datos de la clase Usuario.
    */
    protected $table = 'usuarios';

    /*
    La propiedad $fillable indica los campos de la 
     tabla que se pueden llenar o actualizar. 
    */
    protected $fillable = [
        'usuario',
        'contraseña',
        'email'
    ];
}
