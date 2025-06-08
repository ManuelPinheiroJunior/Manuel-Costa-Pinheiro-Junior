@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Pedidos</h1>
        <a href="{{ route('pedidos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Novo Pedido
        </a>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('pedidos.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="cliente" class="form-label">Cliente</label>
                    <input type="text" class="form-control" id="cliente" name="cliente" value="{{ request('cliente') }}" placeholder="Nome do cliente...">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Todos</option>
                        <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="em_processamento" {{ request('status') == 'em_processamento' ? 'selected' : '' }}>Em Processamento</option>
                        <option value="concluido" {{ request('status') == 'concluido' ? 'selected' : '' }}>Concluído</option>
                        <option value="cancelado" {{ request('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="data_inicio" class="form-label">Data Início</label>
                    <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="{{ request('data_inicio') }}">
                </div>
                <div class="col-md-2">
                    <label for="data_fim" class="form-label">Data Fim</label>
                    <input type="date" class="form-control" id="data_fim" name="data_fim" value="{{ request('data_fim') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Pedidos -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Data de Criação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pedidos as $pedido)
                            <tr>
                                <td>{{ $pedido->cliente->nomeCliente }}</td>
                                <td>{{ $pedido->dt_pedido->format('d/m/Y H:i') }}</td>
                                <td>
                                    @switch($pedido->status)
                                        @case('Pago')
                                            <span class="badge bg-success text-white">Pago</span>
                                            @break
                                        @case('Em Aberto')
                                            <span class="badge bg-warning text-dark">Em Aberto</span>
                                            @break
                                        @default
                                            <span class="badge bg-danger text-white">Cancelado</span>
                                    @endswitch
                                </td>
                                <td>
                                    R$ {{ number_format($pedido->itens->sum(function($item) {
                                        return $item->quantidade * $item->valor_unitario;
                                    }), 2, ',', '.') }}
                                </td>
                                <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-sm btn-info" title="Visualizar">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-sm btn-primary" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este pedido?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Nenhum pedido encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div class="d-flex justify-content-center mt-4">
                {{ $pedidos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 