@extends('layouts.app')

@section('content')

<div class="container text-center">
    <h1>Compras</h1>
</div>
    
    @if(session('mensagem'))
    <div class="alert alert-success">
            {{ session('mensagem') }}
        </div>
    @endif
<hr>
<div class="container" >
<div class="container text-center" >
   <h4> Compras Efetuadas</h4>
</div>

@forelse ($compras as $compra)
<h5>Pedido: {{$compra->id}}</h5>
<h5>Data: {{$compra->created_at->format('d/m/Y H:i')}}</h5>

<form action="{{ route('carrinho.cancelar') }}" method="POST">
@csrf
<input type="hidden" name="pedido_id" value="{{$compra->id}}">


    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Produto</th>
                <th>Valor</th>
                <th>Desconto</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total_pedido = 0;   
            @endphp
            @foreach ($compra->itens_pedidos_produtos as $itens_pedido)
                @php
                    $total_produto = $itens_pedido->valor - $itens_pedido->desconto;
                    $total_pedido += $total_produto;
                @endphp
                <tr>
                <td>
                    @if ($itens_pedido->status == 'PA')
                    <input type="checkbox" id="item-{{$itens_pedido->id}}" name="id[]" value="{{$itens_pedido->id}}">
                    <label for="item-{{$itens_pedido->id}}">selecionar</label>                 
                        
                    @else
                        <h6>Produto Cancelado</h6>
                    
                    @endif
                </td>
                <td>{{$itens_pedido->produto->nome}}</td>
                <td>R$: {{number_format($itens_pedido->valor,2,',','.')}}</td>
                <td>R$: {{number_format($itens_pedido->desconto,2,',','.')}}</td>
                <td>R$: {{number_format($total_produto,2,',','.')}}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <button type="submit" class="btn btn-danger">Cancelar</button>
                </td>
            </tr>
        </tfoot>
    </table>
</form>   
<div class="container text-center">
<h3>Total da compra:{{number_format($total_pedido,2,',','.')}}</h3>
</div>
@empty
    <div class="container text-center">
        <h3>Nenhum Pedido Concluido</h3>
    </div>



@endforelse
</div>
<hr>
<hr>
<hr>





<div class="container" >
    <div class="container text-center" >
       <h4> Compras Canceladas</h4>
    </div>
    
    @forelse ($cancelados as $compra)
    <h5>Pedido: {{$compra->id}}</h5>
    <h5>Data: {{$compra->created_at->format('d/m/Y H:i')}}</h5>
    
    <table class="table">
        <thead>
            <tr>
                <th>Quantidade</th>
                <th>Produto</th>
                <th>Valor</th>
                <th>Desconto</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
             $total_pedido = 0;   
            @endphp
            @foreach ($compra->itens_pedidos_produtos as $itens_pedido)
                @php
                    $total_produto = $itens_pedido->valor - $itens_pedido->desconto;
                    $total_pedido += $total_produto;
                @endphp
                <tr>
                <td>{{$itens_pedidos->qtd}}</td>
                <td>{{$itens_pedido->produto->nome}}</td>
                <td>R$: {{number_format($itens_pedidos->valor,2,',','.')}}</td>
                <td>R$: {{number_format($itens_pedidos->desconto,2,',','.')}}</td>
                <td>R$: {{number_format($total_produto,2,',','.')}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="container text-center">
    <h3>Total da compra:{{number_format($total_pedido,2,',','.')}}</h3>
    </div>
    @empty
        <div class="container text-center">
            <h3>Nenhum Pedido Cancelado</h3>
        </div>
    
    
    
    @endforelse
    </div>
    
@endsection