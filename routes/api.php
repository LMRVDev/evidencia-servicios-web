
<?php

/*
El archivo routes/api.php se encarga de definir las rutas 
 para las solicitudes HTTP que se envían a la aplicación.
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\studentController;
use App\Http\Controllers\Api\usuarioController;

/*
La clase Route define los métodos HTTP (get, post, put, create)
 que se ejecutarán en una derterminada ruta "/" tambien especifica
  la clase controller y la respectiva función a ejecutar.
*/

Route::get('/usuarios', [usuarioController::class, 'listar']);

Route::post('/usuario', [usuarioController::class, 'save']);

Route::put('/usuario/{id}', [usuarioController::class, 'actualizar']);

Route::delete('/usuario/{id}', [usuarioController::class, 'eliminar']);



