<?php

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

Route::get('/home', 'App\Http\Controllers\Admin\HomeController@index')->middleware(['auth'])->name('home');
Route::get('home/{id}/filial', 'App\Http\Controllers\Admin\HomeController@filial')->middleware(['auth'])->name('home.filial');

Route::get('/emails', 'App\Http\Controllers\Admin\EmailController@index')->middleware(['auth'])->name('emails.index');
Route::get('/emails/search', 'App\Http\Controllers\Admin\EmailController@search')->middleware(['auth'])->name('emails.search');
Route::get('/emails/create', 'App\Http\Controllers\Admin\EmailController@create')->middleware(['auth'])->name('emails.create');
Route::any('/emails/store', 'App\Http\Controllers\Admin\EmailController@store')->middleware(['auth'])->name('emails.store');
Route::get('emails/{id}/edit', 'App\Http\Controllers\Admin\EmailController@edit')->middleware(['auth'])->name('emails.edit');
Route::any('emails/{id}/update', 'App\Http\Controllers\Admin\EmailController@update')->middleware(['auth'])->name('emails.update');
Route::get('emails/{id}/show', 'App\Http\Controllers\Admin\EmailController@show')->middleware(['auth'])->name('emails.show');
Route::get('emails/{id}/destroy', 'App\Http\Controllers\Admin\EmailController@destroy')->middleware(['auth'])->name('emails.destroy');

Route::get('/setores', 'App\Http\Controllers\Admin\SetorController@index')->middleware(['auth'])->name('setores.index');
Route::get('/setores/search', 'App\Http\Controllers\Admin\SetorController@search')->middleware(['auth'])->name('setores.search');
Route::get('/setores/create', 'App\Http\Controllers\Admin\SetorController@create')->middleware(['auth'])->name('setores.create');
Route::any('/setores/store', 'App\Http\Controllers\Admin\SetorController@store')->middleware(['auth'])->name('setores.store');
Route::get('setores/{id}/edit', 'App\Http\Controllers\Admin\SetorController@edit')->middleware(['auth'])->name('setores.edit');
Route::any('setores/{id}/update', 'App\Http\Controllers\Admin\SetorController@update')->middleware(['auth'])->name('setores.update');
Route::get('setores/{id}/show', 'App\Http\Controllers\Admin\SetorController@show')->middleware(['auth'])->name('setores.show');
Route::get('setores/destroy', 'App\Http\Controllers\Admin\SetorController@destroy')->middleware(['auth'])->name('setores.destroy');

Route::get('/filiais', 'App\Http\Controllers\Admin\FilialController@index')->middleware(['auth'])->name('filiais.index');
Route::get('/filiais/search', 'App\Http\Controllers\Admin\FilialController@search')->middleware(['auth'])->name('filiais.search');
Route::get('/filiais/create', 'App\Http\Controllers\Admin\FilialController@create')->middleware(['auth'])->name('filiais.create');
Route::any('/filiais/store', 'App\Http\Controllers\Admin\FilialController@store')->middleware(['auth'])->name('filiais.store');
Route::get('filiais/{id}/edit', 'App\Http\Controllers\Admin\FilialController@edit')->middleware(['auth'])->name('filiais.edit');
Route::any('filiais/{id}/update', 'App\Http\Controllers\Admin\FilialController@update')->middleware(['auth'])->name('filiais.update');
Route::get('filiais/{id}/show', 'App\Http\Controllers\Admin\FilialController@show')->middleware(['auth'])->name('filiais.show');
Route::get('filiais/destroy', 'App\Http\Controllers\Admin\FilialController@destroy')->middleware(['auth'])->name('filiais.destroy');

Route::get('/tipodocumentos', 'App\Http\Controllers\Admin\TipoDocumentoController@index')->middleware(['auth'])->name('tipodocumentos.index');
Route::get('/tipodocumentos/search', 'App\Http\Controllers\Admin\TipoDocumentoController@search')->middleware(['auth'])->name('tipodocumentos.search');
Route::get('/tipodocumentos/create', 'App\Http\Controllers\Admin\TipoDocumentoController@create')->middleware(['auth'])->name('tipodocumentos.create');
Route::any('/tipodocumentos/store', 'App\Http\Controllers\Admin\TipoDocumentoController@store')->middleware(['auth'])->name('tipodocumentos.store');
Route::get('tipodocumentos/{id}/edit', 'App\Http\Controllers\Admin\TipoDocumentoController@edit')->middleware(['auth'])->name('tipodocumentos.edit');
Route::any('tipodocumentos/{id}/update', 'App\Http\Controllers\Admin\TipoDocumentoController@update')->middleware(['auth'])->name('tipodocumentos.update');
Route::get('tipodocumentos/{id}/show', 'App\Http\Controllers\Admin\TipoDocumentoController@show')->middleware(['auth'])->name('tipodocumentos.show');
Route::get('tipodocumentos/destroy', 'App\Http\Controllers\Admin\TipoDocumentoController@destroy')->middleware(['auth'])->name('tipodocumentos.destroy');

Route::get('/grupos', 'App\Http\Controllers\Admin\GrupoController@index')->middleware(['auth'])->name('grupos.index');
Route::get('/grupos/search', 'App\Http\Controllers\Admin\GrupoController@search')->middleware(['auth'])->name('grupos.search');
Route::get('/grupos/create', 'App\Http\Controllers\Admin\GrupoController@create')->middleware(['auth'])->name('grupos.create');
Route::any('/grupos/store', 'App\Http\Controllers\Admin\GrupoController@store')->middleware(['auth'])->name('grupos.store');
Route::get('grupos/{id}/edit', 'App\Http\Controllers\Admin\GrupoController@edit')->middleware(['auth'])->name('grupos.edit');
Route::any('grupos/{id}/update', 'App\Http\Controllers\Admin\GrupoController@update')->middleware(['auth'])->name('grupos.update');
Route::get('grupos/{id}/show', 'App\Http\Controllers\Admin\GrupoController@show')->middleware(['auth'])->name('grupos.show');
Route::get('grupos/destroy', 'App\Http\Controllers\Admin\GrupoController@destroy')->middleware(['auth'])->name('grupos.destroy');

Route::get('permissoes/{id}/index', 'App\Http\Controllers\Admin\PermissaoController@index')->middleware(['auth'])->name('permissoes.index');
Route::any('permissoes/{id}/store', 'App\Http\Controllers\Admin\PermissaoController@store')->middleware(['auth'])->name('permissoes.store');
Route::get('permissoes/{id}/edit', 'App\Http\Controllers\Admin\PermissaoController@edit')->middleware(['auth'])->name('permissoes.edit');
Route::get('permissoes/{id}/destroy', 'App\Http\Controllers\Admin\PermissaoController@destroy')->middleware(['auth'])->name('permissoes.destroy');
Route::any('permissoes/{id}/update', 'App\Http\Controllers\Admin\PermissaoController@update')->middleware(['auth'])->name('permissoes.update');

Route::resource('usuarios', 'App\Http\Controllers\Admin\UserController');
Route::get('usuario/password', 'App\Http\Controllers\Admin\UserController@password')->middleware(['auth'])->name('usuario.password');
Route::any('usuario/password/update', 'App\Http\Controllers\Admin\UserController@password_update')->middleware(['auth'])->name('usuario.password.update');

Route::get('/documentos', 'App\Http\Controllers\Admin\DocumentoController@index')->middleware(['auth'])->name('documentos.index');
Route::get('/documentos/search', 'App\Http\Controllers\Admin\DocumentoController@search')->middleware(['auth'])->name('documentos.search');
Route::get('/documentos/create', 'App\Http\Controllers\Admin\DocumentoController@create')->middleware(['auth'])->name('documentos.create');
Route::any('/documentos/store', 'App\Http\Controllers\Admin\DocumentoController@store')->middleware(['auth'])->name('documentos.store');
Route::get('documentos/{id}/edit', 'App\Http\Controllers\Admin\DocumentoController@edit')->middleware(['auth'])->name('documentos.edit');
Route::any('documentos/{id}/update', 'App\Http\Controllers\Admin\DocumentoController@update')->middleware(['auth'])->name('documentos.update');
Route::get('documentos/{id}/show', 'App\Http\Controllers\Admin\DocumentoController@show')->middleware(['auth'])->name('documentos.show');
Route::get('documentos/destroy', 'App\Http\Controllers\Admin\DocumentoController@destroy')->middleware(['auth'])->name('documentos.destroy');

Route::get('imagens/{id}/index', 'App\Http\Controllers\Admin\ImagemController@index')->middleware(['auth'])->name('imagens.index');
Route::any('imagens/{id}/store', 'App\Http\Controllers\Admin\ImagemController@store')->middleware(['auth'])->name('imagens.store');
Route::get('imagens/{id}/edit', 'App\Http\Controllers\Admin\ImagemController@edit')->middleware(['auth'])->name('imagens.edit');
Route::get('imagens/{id}/destroy', 'App\Http\Controllers\Admin\ImagemController@destroy')->middleware(['auth'])->name('imagens.destroy');
Route::any('imagens/{id}/update', 'App\Http\Controllers\Admin\ImagemController@update')->middleware(['auth'])->name('imagens.update');
Route::get('imagens/{id}/print', 'App\Http\Controllers\Admin\ImagemController@print')->middleware(['auth'])->name('imagens.print');
Route::get('imagens/send', 'App\Http\Controllers\Admin\ImagemController@send')->middleware(['auth'])->name('imagens.send');

Route::get('/rel_log', 'App\Http\Controllers\Admin\LogController@index')->middleware(['auth'])->name('rel.log');
Route::get('/logs/relatorio', 'App\Http\Controllers\Admin\LogController@relatorio')->middleware(['auth'])->name('logs.relatorio');

Route::get('/', function () {
    return view('welcome');
});

Route::get('usuario/logout', 'App\Http\Controllers\Auth\AuthenticatedSessionController@destroy')->name('usuario.logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


