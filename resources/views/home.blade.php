@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Painel de Controle</div>

                <div class="card-body">

                       <div class="alert alert-success" role="alert">

                       </div>


                    Loja Virtual
                </div>
            </div>
        </div>
    </div>
    <hr>
    @foreach($produtos as $produto)
    <a href="{{route('home.show', $produto->id)}}">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{$produto->nome}}</div>

                    <div class="card-body">

                           <div class="alert alert-success" role="alert">

                           </div>

                        <h5>{{$produto->descricao}}</h5>
                        <br>
                        <h5>{{$produto->valor}}</h5>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <hr>
    @endforeach
</div>
@endsection
