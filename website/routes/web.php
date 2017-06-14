<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix'=>'admin'], function(){
    Route::get('/', function () {
        return view('welcome');
    });
    Route::any('getSecciones', 'admin\SeccionesCtrl@getSecciones');
    Route::any('registrarSeccion', 'admin\SeccionesCtrl@registrar');
});


Route::group(['prefix'=>'catedraticos'], function(){
    Route::get('/{usuarioId}', 'admin\SeccionesCtrl@getSeccionesCalificar');
});