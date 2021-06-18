<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\ItensPedido;
use App\Models\CupomDesconto;
use Illuminate\Support\Facades\Auth;

class CarrinhoController extends Controller
{

    protected $repositoryPedido;
    protected $repositoryProduto;
    protected $repositoryItensPedido;
    protected $repositoryCupom;

    public function __construct(Request $request, Pedido $pedido, Produto $produto, ItensPedido $itensPedido, CupomDesconto $cupom){
        $this->request = $request;
        $this->repositoryPedido = $pedido;
        $this->repositoryProduto = $produto;
        $this->repositoryItensPedido = $itensPedido;
        $this->repositoryCupom = $cupom;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pedidos = Pedido::where([
            'status' => 'RE',
            'user_id' => Auth::id()
        ])->get();
        return view('carrinho.index', [
            'pedidos' => $pedidos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function adicionar(Request $request)
    {
        //
        $idProduto = $request->only('id');

        $produto = $this->repositoryProduto->where('id', $idProduto)->first();

        if (empty($produto->id)) {
            # code...
            $mensagem = 'Produto não encontrado!.';
            $produtos = $this->repositoryProduto->paginate();

            return view('home', [
                'produtos' => $produtos,
                'mensagem' => $mensagem
            ]);
        }
        $idUsuario = Auth::id();

        $idPedido = $this->repositoryPedido->buscarPedido([
            'user_id' => $idUsuario,
            'status' => 'RE'
        ]);
        if (!$idPedido) {
            # code...
            $Pedido_novo = Pedido::create([
                'user_id' => $idUsuario,
                'status' => 'RE'
            ]);
            $idPedido = $Pedido_novo->id;
        }
        $this->repositoryItensPedido->create([
            'pedido_id' => $idPedido,
            'produto_id' => $produto->id,
            'status'=> 'RE',
            'valor' => $produto->valor
        ]);
        return redirect()->route('carrinho.index')->with('mensagem', 'Produto adicionado com sucesso!.');
    }

<<<<<<< HEAD
    public function concluir(Request $request){
        $idPedido = $request->input('pedido_id');
        $idUsuario = Auth::id();

        $check_pedido = $this->repositoryPedido->where([
            'id' => $idPedido,
            'user_id' => $idUsuario,
            'status' => 'RE'
        ]);

        if (!$check_pedido) {
            # code...
            return redirect()->rote('carrinho.index')->with('mensagem', 'Pedido não encontrado!.');
        }
        $check_produto = $this->repositoryItensPedido->where([
            'pedido_id' => $idPedido
        ])->exists();
        if (!$check_produto) {
            # code...
            return redirect()->route('carrinho.index')->with('mensagem', 'Produto não encontrado!.');
        }
        $this->repositoryPedido->where([
            'pedido_id' => $idPedido
        ])->
    }


    public function compras(){
        $compras = $this->repositoryPedido->where([
            'status' => 'PA',
            'user_id' => Auth::id()
        ])->orderBy('created_at', 'desc')->get();

        $cancelados = $this->repositoryPedido->where([
            'status' => 'CA',
            'user_id' => Auth::id()
        ])->orderBy('created_at', 'desc')->get();

        return view('carrinho.compras', [
            'compras' => $compras,
            'cancelados' => $cancelados
        ]);
    }

    public function cancelar(Request $request){
        $idPedido = $request->input('pedido_id');
        $idItens_pedido =  $request->input('id');
        $idUsuario = Auth::id();

        if (empty($idItens_pedido)) {
            # code...
            return redirect()->route('carrinho.compras')->with('mensagem', 'Nenhum item selecionados!.');
        }

        $check_pedido = $this->repositoryPedido->where([
            'id' => $idPedido,
            'usur_id' => $idUsuario,
            'status' => 'PA'
        ])->exists();

        if (!$check_pedido) {
            # code...
            return redirect()->route('carrinho.compras')->with('mensagem', 'Pedido não encontrado!.');
        }

        $check_Produtos = $this->repositoryItensPedido->where([
            'pedido_id' => $idPedido,
            'status' => 'PA'
        ])->whereIn('id', $idItens_pedido)->exists();

        if (!$check_Produtos) {
            # code...
            return redirect()->route('carrinho.compras')->with('mensagem', 'Produto não encontrado!.');
        }

        $this->repositoryItensPedido->where([
            'pedido_id' => $idPedido,
            'status' => 'PA'
        ])->whereIn('id', $idItens_pedido)->update([
            'status' => 'CA'
        ]);
        $check_pedido_cancel = $this->repositoryItensPedido->where([
            'pedido_id' => $idPedido,
            'status' => 'PA'
        ])->exists();

        if (!$check_pedido_cancel) {
            # code...
            $this->repositoryPedido->where([
                'id' => $idPedido
            ])->update([
                'status' => 'CA'
            ]);

            $mensagem = 'Compra cancelada pelo usuário com sucesso!.';
        } else {
            # code...

            $mensagem = 'Produto cancelado com sucesso!.';
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
