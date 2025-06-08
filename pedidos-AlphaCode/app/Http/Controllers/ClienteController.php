<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\ClienteRequest;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::query();

        // Filtros
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomeCliente', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Ordenação
        $sortField = $request->get('sort', 'nomeCliente');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        // Paginação
        $clientes = $query->paginate(20);

        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomeCliente' => 'required|string|max:255',
            'cpf' => ['required', 'string', 'max:14', 'regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/'],
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:20',
            'endereco' => 'required|string|max:255',
            'cidade'=> 'required|string|max:100',
            'estado' => 'required|string|max:2',
            'cep' => 'required|string|max:9',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente criado com sucesso!');
    }

    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nomeCliente' => 'required|string|max:255',
            'cpf' => ['required', 'string', 'max:14', 'regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/'],
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:20',
            'endereco' => 'required|string|max:255',
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso!');
    }
}
