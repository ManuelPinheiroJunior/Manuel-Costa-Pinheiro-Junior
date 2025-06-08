@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Clientes</h1>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Novo Cliente
        </a>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('clientes.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Nome, CPF ou email...">
                </div>
                <div class="col-md-3">
                    <label for="sort" class="form-label">Ordenar por</label>
                    <select class="form-select" id="sort" name="sort">
                        <option value="nomeCliente" {{ request('sort') == 'nomeCliente' ? 'selected' : '' }}>Nome</option>
                        <option value="cpf" {{ request('sort') == 'cpf' ? 'selected' : '' }}>CPF</option>
                        <option value="email" {{ request('sort') == 'email' ? 'selected' : '' }}>Email</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="direction" class="form-label">Direção</label>
                    <select class="form-select" id="direction" name="direction">
                        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Crescente</option>
                        <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Decrescente</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Clientes -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->nomeCliente }}</td>
                                <td>{{ preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cliente->cpf) }}</td>
                                <td>{{ $cliente->email }}</td>
                                <td>{{ preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $cliente->telefone) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-sm btn-info" title="Visualizar">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Nenhum cliente encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div class="d-flex justify-content-center mt-4">
                {{ $clientes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 