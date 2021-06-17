@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1>Carrinho</h1>
</div>

@if(session('message'))
<div class="alert alert-success">
    {{session('message')}}
</div>
@endif
<div class="container">
    <div class="container text-center">
        <h1>número do pedido:</h1>
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
            <tr>
                <td>
                    <a href="#" onclick=""><ion-icon name="remove-circle-outline"></ion-icon></a>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="container text-center">
    <h1>Valor total da compra: R$:</h1>
    <br>
    <form action="" method="POST">
        @csrf
        <input type="hidden" name="pedido_id" value="">
        <label for="cupom">Digite o cupom:</label>
        <input type="text" id="cupom" name="cupom">
        <button type="submit" class="btn btn-primary">Aplicar Cupom</button>
    </form>

    <form action="" method="POST">
        @csrf
        <input type="hidden" name="pedido_id" value="">
        <button type="submit" class="btn btn-primary">Concluir Compra</button>
    </form>
</div>


<hr>
<h1>Carrinho Vazio</h1>

<hr>
<div class="container">
    <a href="{{route('home')}}" class="btn btn-primary">Continuar Comprando</a>
</div>

<form action="" method="POST" id="form-remover-produto">
    @csrf
    @method('DELETE')
    <input type="hidden" name="pedido_id">
    <input type="hidden" name="produto_id">
    <input type="hidden" name="item">
</form>

<form action="" method="POST" id="form-adicionar-produto">
    @csrf
    <input type="hidden" name="id">
</form>

@push('scripts')
   <script type="text/javascript" src=""></script>
@endpush

@endsection
