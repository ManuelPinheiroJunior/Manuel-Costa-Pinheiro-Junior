<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $query = Produto::query();

        // Filtro de busca
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome_produto', 'like', "%{$search}%")
                  ->orWhere('nome_produto', 'like', "%{$search}%");
            });
        }

        // Ordenação
        $sort = $request->get('sort', 'nome_produto');
        $direction = $request->get('direction', 'asc');
        $query->orderBy($sort, $direction);

        // Paginação
        $produtos = $query->paginate(10)->withQueryString();

        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome_produto' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:500',
            'preco' => 'required|numeric|min:0',
            'estoque' => 'required|integer|min:0',
        ]);

        $produto = Produto::create([
            'nome_produto' => $request->nome_produto,
            'descricao' => $request->descricao,
            'valor_unitario' => $request->preco,
            'quantidade' => $request->estoque,
            'cod_barras' => 'P' . rand(1000000000, 9999999999),
        ]);

        return redirect()->route('produtos.index')
            ->with('success', 'Produto criado com sucesso!');
    }

    public function show(Produto $produto)
    {
        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        $validated = $request->validate([
            'nome_produto' => 'required|max:255',
            'descricao' => 'nullable|string|max:500',
            'valor_unitario' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:0'
        ]);

        $produto->update([
            'nome_produto' => $request->nome_produto,
            'descricao' => $request->descricao,
            'valor_unitario' => $request->valor_unitario,
            'quantidade' => $request->quantidade
        ]);

        return redirect()->route('produtos.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();

        return redirect()->route('produtos.index')
            ->with('success', 'Produto excluído com sucesso!');
    }
}
