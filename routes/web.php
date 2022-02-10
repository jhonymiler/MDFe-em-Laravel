<?php

use App\Http\Controllers\LoginController;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;



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



// Route::get('/', function () {
//     $lista = array();
//     return view('home', [
//         'lista' => $lista
//     ]);
// })->middleware('auth');

Route::get('/', 'MdfeController@index');


Route::prefix('/login')->group(function () {
    Route::get('/', 'LoginController@index')->name('login');
    Route::post('/acesso', 'LoginController@acesso')->name('acesso');
    Route::get('/sair', 'LoginController@sair');
});

Route::prefix('/empresas')->group(function () {
    Route::get('/{id?}', 'EmpresasController@index')->name('empresas');
    Route::post('/save', 'EmpresasController@save')->name('empresas.save');
    Route::get('/certificado', 'EmpresasController@certificado');
    Route::get('/download', 'EmpresasController@download');
    Route::post('/certificado', 'EmpresasController@saveCertificado');
    Route::post('/getCertificado', 'EmpresasController@getCertificado');
    Route::get('/deleteCertificado', 'EmpresasController@deleteCertificado');
    Route::get('/excluir/{id}', 'EmpresasController@excluir');
    Route::post('/excluir', 'EmpresasController@excluirMultiplos')->name('empresas.excluirMultiplos');
});

Route::group(['prefix' => 'veiculos'], function () {
    Route::get('/{id?}', 'VeiculoController@index')->name('veiculos');
    Route::post('/save', 'VeiculoController@save')->name('veiculos.save');
    Route::get('/excluir/{id}', 'VeiculoController@excluir');
    Route::post('/excluir', 'VeiculoController@excluirMultiplos')->name('veiculos.excluirMultiplos');
});


Route::group(['prefix' => 'cidades'], function () {
    Route::get('/all', 'CidadeController@all');
    Route::get('/find/{id}', 'CidadeController@find');
    Route::get('/findNome/{nome}', 'CidadeController@findNome');
});

Route::group(['prefix' => 'mdfe'], function () {
    Route::get('/', 'MdfeController@index');
    Route::get('/novo', 'MdfeController@nova')->name('mdfe.novo');
    Route::get('/lista', 'MdfeController@lista');
    Route::get('/detalhar/{id}', 'MdfeController@detalhar');
    Route::get('/delete/{id}', 'MdfeController@delete');
    Route::get('/edit/{id}', 'MdfeController@edit');
    Route::post('/salvar', 'MdfeController@salvar');
    Route::post('/update', 'MdfeController@update');
    Route::get('/filtro', 'MdfeController@filtro');
    Route::get('/gerarXml/{id}', 'EmiteMdfeController@gerarXml');
});

Route::group(['prefix' => 'mdfeSefaz'], function () {
    Route::post('/enviar', 'EmiteMdfeController@enviar');
    Route::get('/imprimir/{id}', 'EmiteMdfeController@imprimir');
    Route::post('/cancelar', 'EmiteMdfeController@cancelar');
    Route::post('/consultar', 'EmiteMdfeController@consultar');

    Route::get('/naoEncerrados', 'EmiteMdfeController@naoEncerrados');
    Route::post('/encerrar', 'EmiteMdfeController@encerrar');
    Route::get('/enviarXml', 'EmiteMdfeController@enviarXml');
});
