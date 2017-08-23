@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Lista de leituras</div>
                <div class="panel-body">
                @foreach($leituras as $leitura)
                    <ul>
                    <li>Leitura {{$leitura->id}}: {{$leitura->leitura}}</li>
                    <a href="{{"/imagem/".$leitura->id}}" target="_blank">Ver imagem</a>
                    </ul>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
