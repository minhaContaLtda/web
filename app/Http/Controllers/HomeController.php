<?php

namespace App\Http\Controllers;

use App\Leitura;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Lista todas leituras do usuario

        $leituras = Leitura::all();

        return view('home', array('leituras' => $leituras));
    }
}
