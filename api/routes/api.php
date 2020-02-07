<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * User Auth Routes
 */
Route::post('login',    'Api\Auth\LoginController@login');
Route::post('logout',   'Api\Auth\LoginController@logout');
Route::post('refresh',  'Api\Auth\LoginController@refresh');
Route::post('me',       'Api\Auth\LoginController@me');
Route::post('sendPasswordResetLink', 'Api\Auth\ResetPasswordController@sendEmail');
Route::post('resetPassword',         'Api\Auth\ChangePasswordController@process');


/*
|--------------------------------------------------------------------------
| USUARIOS ROUTERS
|--------------------------------------------------------------------------
*/
Route::get('usuarios',         'Api\UsuariosController@index');
Route::post('add/usuarios',        'Api\UsuariosController@store');
Route::get('usuarios/{id}',    'Api\UsuariosController@show');
Route::put('usuarios/{id}',    'Api\UsuariosController@update');
Route::delete('usuarios/{id}', 'Api\UsuariosController@destroy');

/**
 * Permissões
 */

Route::resource('permissoes', 'Api\Authorization\PermissionController');
Route::resource('papeis', 'Api\Authorization\RoleController');

/**
 * Cores Routes
 */
Route::get('cores',         'Api\CoresController@index');
Route::post('cores',        'Api\CoresController@store');
Route::get('cores/{id}',    'Api\CoresController@show');
Route::put('cores/{id}',    'Api\CoresController@update');
Route::delete('cores/{id}', 'Api\CoresController@destroy');

/*
|--------------------------------------------------------------------------
| DESPESAS ROUTERS
|--------------------------------------------------------------------------
*/
Route::get('add/despesas', 'DespesaController@create')->name('despesa.create');
Route::post('salvar/despesas', 'DespesaController@store')->name('despesa.store');
Route::get('editar/despesas/{id}', 'DespesaController@edit')->name('despesa.edit');
Route::put('update/despesas', 'DespesaController@update')->name('despesa.update');
Route::delete('delete/despesas/{id}', 'DespesaController@destroy')->name('destroy');
Route::get('view/despesas/{id}', 'DespesaController@index')->name('despesa.index');
Route::get('despesas/{id}', 'DespesaController@totalDispesa')->name('despesa.totalDispesa');


/*
|--------------------------------------------------------------------------
| EMPRESAS ROUTERS
|--------------------------------------------------------------------------
*/
Route::get('empresa/show/{id}', 'EmpresaController@show')->name('empresa.show');
Route::post('salvar/empresa', 'EmpresaController@store')->name('empresa.store');
Route::get('editar/empresa/{id}', 'EmpresaController@edit')->name('empresa.edit');
Route::put('update/empresa', 'EmpresaController@update')->name('empresa.update');
Route::delete('delete/empresa/{id}', 'EmpresaController@destroy')->name('empresa.destroy');
Route::get('view/empresa', 'EmpresaController@index')->name('empresa.index');

/*
|--------------------------------------------------------------------------
| ITENS ROUTERS
|--------------------------------------------------------------------------
*/
Route::get('add/item', 'ItemController@create')->name('item.create');
Route::post('salvar/item', 'ItemController@store')->name('item.store');
Route::get('editar/item/{id}', 'ItemController@edit')->name('item.edit');
Route::put('update/item', 'ItemController@update')->name('item.update');
Route::delete('delete/item/{id}', 'ItemController@destroy')->name('item.destroy');
Route::get('view/item', 'ItemController@index')->name('item.index');

/*
|--------------------------------------------------------------------------
| POUPANÇA ROUTERS
|--------------------------------------------------------------------------
*/
Route::post('salvar/poupanca', 'PoupancaController@store')->name('poupanca.store');
Route::get('view/poupanca/{id}', 'PoupancaController@index')->name('poupanca.index');

/*
|--------------------------------------------------------------------------
| RENDIMENTO ROUTERS
|--------------------------------------------------------------------------
*/
Route::get('estatistica/{id}', 'RendimentoController@estatistica');
Route::get('add/rendimento', 'RendimentoController@create')->name('rendimento.create');
Route::post('salvar/rendimento', 'RendimentoController@store')->name('rendimento.store');
Route::get('editar/rendimento/{id}', 'RendimentoController@edit')->name('rendimento.edit');
Route::put('update/rendimento', 'RendimentoController@update')->name('rendimento.update');
Route::delete('delete/rendimento/{id}', 'RendimentoController@destroy')->name('rendimento.destroy');
Route::get('view/rendimento/{id}', 'RendimentoController@index')->name('rendimento.index');
Route::get('mensal/rendimento/{id}', 'RendimentoController@mensal')->name('rendimento.mensal');