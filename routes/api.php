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
 * Autenticacao (/api/auth/)
 */
Route::group(['prefix' => 'auth'], function()
{
    /**
     * Login
     * /api/auth/login
     */
    Route::post('login', 'ApiController@login');

    Route::group(['middleware' => 'api'], function()
    {
        /**
         * Logout
         * /api/auth/logout
         */
        Route::post('logout', 'ApiController@logout');
    });
});

/**
 * Usuário (/api/usuario/)
 */
Route::group(['prefix' => 'usuario'], function()
{
    /**
     * Cadastra novo usuário
     * // /api/user/register
     */
    Route::post('cadastrar', 'ApiController@criarUsuario');

    Route::group(['middleware' => 'api'], function()
    {
        /**
         * Atualiza perfil do usuário
         * /api/user/register
         */
        Route::post('atualizar', 'ApiController@atualizarUsuario');
        /**
         * Obter dados do usuário
         * /api/user/obterDados
         */
        Route::get('obterDados', 'ApiController@obterDadosUsuario');
    });
});
