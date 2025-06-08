@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Produtos</h1>
            <a href="{{ route('produtos.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Novo Produto
            </a>
        </div>

        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('produtos.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Nome ou descrição...">
                    </div>
                    <div class="col-md-3">
                        <label for="sort" class="form-label">Ordenar por</label>
                        <select class="form-select" id="sort" name="sort">
                            <option value="nome" {{ request('sort') == 'nome' ? 'selected' : '' }}>Nome</option>
                            <option value="preco" {{ request('sort') == 'preco' ? 'selected' : '' }}>Preço</option>
                            <option value="estoque" {{ request('sort') == 'estoque' ? 'selected' : '' }}>Estoque</option>
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

        <!-- Lista de Produtos -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produtos as $produto)
                                <tr>
                                    <td>{{ $produto->cod_barras }}</td>
                                    <td>{{ $produto->nome_produto }}</td>
                                    <td>{{ $produto->descricao }}</td>
                                    <td>R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</td>
                                    <td>{{ $produto->quantidade }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('produtos.show', $produto) }}" class="btn btn-sm btn-info" title="Visualizar">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-sm btn-warning" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('produtos.destroy', $produto) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Nenhum produto encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $produtos->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
