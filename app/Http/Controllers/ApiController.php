<?php

namespace App\Http\Controllers;

use App\Anuncio;
use App\Http\Controllers\Auth\AuthController;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    /**
    * Verifica as credenciais com email e password
    * @param Request $request
    * @return string FALSE quando credenciais nao correspondem ou o HASH quando autenticação procede
    */
   public function login(Request $request)
   {
       //Verificar credenciais
       $credentials = $request->only('email', 'password');
       if( Auth::attempt($credentials, false) )
       {
           //Gerar e atualizar token
           $token = str_replace('/','',Hash::make('plain-text'));

           $user = User::where('email', $request->email)->first();
           $user->api_token = $token;
           $user->save();

           return Response::json($token);
       }

       return Response::json(false);
   }

   /**
    * logout da API
    * Apaga o token do usuário logado
    * @param Request $request
    * @return string
    */
   public function logout(Request $request)
   {
       $user = User::where('api_token', $request->api_token)->first();
       if( !empty($user) )
       {
           $user->api_token = NULL;
           $user->save();
       }

       return Response::json(true);
   }

   public function obterDadosUsuario(Request $request)
   {
       $user = User::where('api_token', $request->input('api_token'))->first();
       return Response::json($user);
   }

   public function criarUsuario(Request $request)
   {
       $data = $request->all();
       $data['password'] = Hash::make($request['password']);
       try
       {
           $user = User::create($data);

       }
       catch (Exception $e)
       {
           return Response::json(['error' => $e->getMessage()]);
       }

       return $this->login($request);
   }

   public function atualizarUsuario(Request $request)
   {
       $user = User::where('api_token', $request->input('api_token'))->first();
       if( !empty($user) )
       {
           $user->fill($request->all());
           $user->password = Hash::make($request['password']);
           $user->save();
           return Response::json(true);
       }
       else
       {
           return Response::json(false);
       }
   }
}
