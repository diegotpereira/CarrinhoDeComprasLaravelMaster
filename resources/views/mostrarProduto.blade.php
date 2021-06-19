@extends('layouts.app')

@section('content')

@if(@isset($produto))

<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Imagem</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$produto->nome}}</td>
                <td>{{$produto->descricao}}</td>
                <td>{{$produto->valor}}</td>
                <td><img src="{{ $produto->image }}" class="rounded-circle" width='100' height="100" /></td>
          </tr>
            </tr>
        </tbody>
    </table>
</div>

<div class="container text-center">
    <form action="{{route('carrinho.adicionar')}}" method="post" >
        @csrf
        <input type="hidden" name="id" value="{{$produto->id}}">
        <button type="submit" class="btn btn-primary">Adicionar ao carrinho</button>
    </form>
</div>
@endif

@endsection
