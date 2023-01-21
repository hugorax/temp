<?php

use Illuminate\Support\Facades\Route;


Route::get('hugo', function (){ return "hola"; });

Route::get('/vehiculoResidentes/{anio}/{mes}', 'EstadiaController@informe');


Route::group(['middleware' => ['auth:sanctum']], function () {
    //crud vehiculos
    Route::get('/vehiculos', 'VehiculoController@index');
    Route::get('/tipoCliente', 'VehiculoController@tipos');
    Route::post('/vehiculo', 'VehiculoController@store');
    Route::put('/vehiculo/{vehiculo}', 'VehiculoController@update');

    //crud estadias
    Route::get('/vehiculos/estadias', 'EstadiaController@index');
    Route::get('/vehiculo/estadia/{placa}', 'EstadiaController@show');
    Route::post('/new/vehiculo/estadia', 'VehiculoController@createVehiculoEstadia');
    Route::post('/vehiculo/estadia/ingreso', 'EstadiaController@store');
    Route::post('/vehiculo/estadia/egreso/{estadia}', 'EstadiaController@update');
});