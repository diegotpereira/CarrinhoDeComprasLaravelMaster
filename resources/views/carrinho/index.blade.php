@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1>Carrinho</h1>
</div>

@if(session('messagem'))
<div class="alert alert-success">
    {{session('messagem')}}
</div>
@endif
@forelse($pedidos as $pedido)
<div class="container">
    <div class="container text-center">
        <h1>número do pedido:{{$pedido->id}}</h1>
    </div>
    <hr>
    <table class="table">
        <thead>
            <tr>
                <th>Quantidade</th>
                <th>Produto</th>
                <th>Valor Unidade</th>
                <th>Desconto</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @php
            $total_pedido = 0;
            @endphp

            @foreach($pedido->itens_pedidos as $itens_pedido)
            <tr>
                <td>
                <a href="#" onclick="carrinhoRemoverProduto({{$pedido->id}},{{$itens_pedido->produto_id}},1)"><ion-icon name="remove-circle-outline"></ion-icon></a>
                    {{$itens_pedido->qtd}}
                    <a href="#" onclick="carrinhoAdicionarProduto({{$itens_pedido->produto_id}})"><ion-icon name="add-circle-outline"></ion-icon></a>                    
                    <a href="#" onclick="carrinhoRemoverProduto({{$pedido->id}},{{$itens_pedido->produto_id}},0)">Remover Produto</a>
                </td>
                <td>{{$itens_pedido->produto->nome}}</td>
                <td>R$: {{number_format($itens_pedido->produto->valor,2,',','.')}}</td>
                <td>R$: {{number_format($itens_pedido->descontos,2,',','.')}}</td>
                @php
                $total_produto = $itens_pedido->valores - $itens_pedido->descontos;
                $total_pedido += $total_produto;
                @endphp
                <td>R$: {{number_format($total_produto,2,',','.')}}</td>
            </tr>
        </tbody>
        @endforeach
    </table>
</div>
<div class="container text-center">
    <h1>Valor total da compra: R$: {{number_format($total_pedido,2,',','.')}}</h1>
    <br>
    <form action="{{route('carrinho.desconto')}}" method="POST">
        @csrf
        <input type="hidden" name="pedido_id" value="{{$pedido->id}}">
        <label for="cupom">Digite o cupom:</label>
        <input type="text" id="cupom" name="cupom">
        <button type="submit" class="btn btn-primary">Aplicar Cupom</button>
    </form>

    <form action="{{route('carrinho.concluir')}}" method="POST">
        @csrf
        <input type="hidden" name="pedido_id" value="{{$pedido->id}}">
        <button type="submit" class="btn btn-primary">Concluir Compra</button>
    </form>
</div>

@empty
<hr>
<h1>Carrinho Vazio</h1>
@endforelse
<hr>
<div class="container">
    <a href="{{route('home')}}" class="btn btn-primary">Continuar Comprando</a>
</div>

<form action="{{route('carrinho.remover')}}" method="POST" id="form-remover-produto">
    @csrf
    @method('DELETE')
    <input type="hidden" name="pedido_id">
    <input type="hidden" name="produto_id">
    <input type="hidden" name="item">
</form>

<form action="{{ route('carrinho.adicionar') }}" method="POST" id="form-adicionar-produto">
    @csrf
    <input type="hidden" name="id">
</form>

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/carrinho.js') }}" ></script>
@endpush

@endsection
