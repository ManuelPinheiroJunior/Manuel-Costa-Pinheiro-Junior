<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $query = Pedido::with(['cliente', 'itens.produto']);

        // Filtros
        if ($request->has('cliente')) {
            $query->whereHas('cliente', function($q) use ($request) {
                $q->where('nomeCliente', 'like', "%{$request->cliente}%");
            });
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('data_inicio')) {
            $query->where('dt_pedido', '>=', $request->data_inicio);
        }

        if ($request->has('data_fim')) {
            $query->where('dt_pedido', '<=', $request->data_fim);
        }

        // Ordenação
        $sortField = $request->get('sort', 'dt_pedido');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        // Paginação
        $pedidos = $query->paginate(20);

        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $produtos = Produto::all();
        return view('pedidos.create', compact('clientes', 'produtos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'produtos' => 'required|array',
            'produtos.*' => 'required|exists:produtos,id',
            'quantidades' => 'required|array',
            'quantidades.*' => 'required|integer|min:1',
            'valores' => 'required|array',
            'valores.*' => 'required|numeric|min:0',
            'status' => 'required|in:Em Aberto,Pago,Cancelado'
        ]);

        try {
            DB::beginTransaction();

            // Cria o pedido
            $pedido = Pedido::create([
                'cliente_id' => $request->cliente_id,
                'dt_pedido' => now(),
                'status' => $request->status
            ]);

            // Adiciona os itens do pedido
            foreach ($request->produtos as $index => $produtoId) {
                $pedido->itens()->create([
                    'produto_id' => $produtoId,
                    'quantidade' => $request->quantidades[$index],
                    'valor_unitario' => $request->valores[$index]
                ]);

                // Atualiza o estoque do produto
                $produto = Produto::find($produtoId);
                $produto->quantidade -= $request->quantidades[$index];
                $produto->save();
            }

            DB::commit();

            return redirect()->route('pedidos.index')
                ->with('success', 'Pedido criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erro ao criar pedido: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['cliente', 'itens.produto']);
        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        $pedido->load(['cliente', 'itens.produto']);
        $clientes = Cliente::all();
        $produtos = Produto::all();
        
        return view('pedidos.edit', compact('pedido', 'clientes', 'produtos'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'dt_pedido' => 'required|date',
            'status' => 'required|in:Em Aberto,Pago,Cancelado',
            'produtos' => 'required|array',
            'produtos.*.produto_id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|numeric|min:1',
            'produtos.*.valor_unitario' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();
        try {
            // Atualiza o pedido
            $pedido->update([
                'cliente_id' => $request->cliente_id,
                'dt_pedido' => $request->dt_pedido,
                'status' => $request->status
            ]);

            // Remove os itens antigos
            $pedido->itens()->delete();

            // Adiciona os novos itens
            foreach ($request->produtos as $item) {
                $pedido->itens()->create([
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $item['quantidade'],
                    'valor_unitario' => $item['valor_unitario']
                ]);
            }

            DB::commit();
            return redirect()->route('pedidos.index')->with('success', 'Pedido atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Erro ao atualizar pedido: ' . $e->getMessage());
        }
    }

    public function destroy(Pedido $pedido)
    {
        try {
            DB::beginTransaction();
            
            // Remove os itens do pedido
            $pedido->itens()->delete();
            
            // Remove o pedido
            $pedido->delete();
            
            DB::commit();
            return redirect()->route('pedidos.index')->with('success', 'Pedido excluído com sucesso!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('pedidos.index')->with('error', 'Erro ao excluir pedido: ' . $e->getMessage());
        }
    }

    public function updateStatus(Pedido $pedido, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:Em Aberto,Pago,Cancelado'
        ]);

        $pedido->update($validated);

        return redirect()->route('pedidos.index')
            ->with('success', 'Status do pedido atualizado com sucesso!');
    }
} 