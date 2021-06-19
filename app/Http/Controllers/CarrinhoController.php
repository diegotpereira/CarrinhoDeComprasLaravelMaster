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
            'desconto' => 'null',
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
            return redirect()->route('carrinho.index')->with('mensagem', 'Pedido não encontrado!.');
        }
        $check_produto = $this->repositoryItensPedido->where([
            'pedido_id' => $idPedido
        ])->exists();
        if (!$check_produto) {
            # code...
            return redirect()->route('carrinho.index')->with('mensagem', 'Produto não encontrado!.');
        }
        $this->repositoryItensPedido->where([
            'pedido_id' => $idPedido
        ])->update([
            'status' => 'PA'
        ]);

        $this->repositoryPedido->where([
            'id' => $idPedido
        ])->update([
            'status' => 'PA'
        ]);

        return redirect()->route('carrinho.compras')->with('mensagem', 'Compra efetuada com sucesso!.');
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
        return redirect()->route('carrinho.compras')->with('mensagem',$mensagem);
    }

    public function desconto(Request $request)
    {
        $idPedido = $request->input('pedido_id');
        $cupom = $request->input('cupom');
        $idUsuario = Auth::id();

        if(empty($cupom))
        {
            return redirect()->route('carrinho.index')->with('mensagem','Cupom inválido');
        }

        $cupom = $this->repositoryCupom->where([
            'localizador' => $cupom,
            'ativo' => 'S'
        ])->where('validade','>',date('Y-m-d H:i:s'))->first();
        if(empty($cupom->id))
        {
            return redirect()->route('carrinho.index')->with('mensagem','Cupom não encontrado');
        }


        $check_pedido = $this->repositoryPedido->where([
            'id' => $idPedido,
            'user_id' => $idUsuario,
            'status' => 'RE'
        ])->exists();
        if(!$check_pedido){
            return redirect()->route('carrinho.index')->with('mensagem','Pedido não encontrado');
        }
        
        $itens_pedidos = $this->repositoryPedidoProduto->where([
            'pedido_id' => $idPedido,
            'status' => 'RE'
        ])->get();

        if(empty($itens_pedidos))
        {
            return redirect()->route('carrinho.index')->with('mensagem','Produto não encontrado');
        }

        $aplicou_desconto = false;
        foreach($itens_pedidos as $itens_pedido){
            switch($cupom->modo_desconto)
            {
                case 'percent':
                $valor_desconto = ($itens_pedido->valor * $cupom->desconto) / 100;
            break;
            default:
                $valor_desconto = $cupom->desconto;
        break;        
            }
            $valor_desconto = ($valor_desconto > $itens_pedido->valor) ? $itens_pedido->valor : number_format($valor_desconto,2);
            
            switch($cupom->modo_limite){
                case 'qnt':
                    $qtd_pedido = $this->repositoryItensPedido->whereIn('status',['PA','RE'])->where([
                        'cupom_desconto_id' => $cupom->id
                    ])->count();
                    if($qtd_pedido >= $cupom->limite){
                        /*continue;*/
                    }
                break;
                default:
                $valor_limite_desconto = $this->repositoryItensPedido->whereIn('status',['PA','RE'])->qhere([
                    'cupom_desconto_id' => $cupom->id
                ])->sum('desconto');
                if(($valor_limite_desconto + $valor_desconto) > $cupom->limite ){
                    /*continue;*/
                }
                break;
            }

            $itens_pedido->cupom_desconto_id = $cupom->id;
            $itens_pedido->desconto = $valor_desconto;
            $itens_pedido->update();

            $aplicou_desconto = true;
        }

        if($aplicou_desconto){
            return redirect()->route('carrinho.index')->with('mensagem','Desconto aplicado com sucesso');
        }else{
            return redirect()->route('carrinho.index')->with('mensagem','Desconto esgotado');
        }
        return redirect()->route('carrinho.index');
    }
}
