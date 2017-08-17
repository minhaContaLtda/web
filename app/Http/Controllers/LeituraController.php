<?php

namespace App\Http\Controllers;

use App\Leitura;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LeituraController extends Controller
{
    public function registrar(Request $request)
    {
        $user = User::where('api_token', $request->api_token)->first();
        $leitura = new Leitura();
        $leitura->leitura = $request->leitura;
        $leitura->user_id = $user->id;
        $leitura->save();

        //Salva a imagem
        $path = $request->imagem->storeAs('leituras', $leitura->id.'.jpg');


        return response()->json($path);
    }
}
