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
