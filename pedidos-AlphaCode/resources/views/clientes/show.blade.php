@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detalhes do Cliente</h5>
        <div>
            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nome:</strong> {{ $cliente->nomeCliente }}</p>
                <p><strong>CPF:</strong> {{ $cliente->cpf }}</p>
                <p><strong>Email:</strong> {{ $cliente->email ?? 'Não informado' }}</p>
                <p><strong>Data de Cadastro:</strong> {{ $cliente->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Última Atualização:</strong> {{ $cliente->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="mt-4">
            <h6>Pedidos do Cliente</h6>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cliente->pedidos as $pedido)
                            <tr>
                                <td>{{ $pedido->id }}</td>
                                <td>{{ $pedido->dt_pedido->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $pedido->status === 'Pago' ? 'success' : ($pedido->status === 'Cancelado' ? 'danger' : 'warning') }}">
                                        {{ $pedido->status }}
                                    </span>
                                </td>
                                <td>R$ {{ number_format($pedido->itens->sum(function($item) {
                                    return $item->quantidade * $item->valor_unitario;
                                }), 2, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('pedidos.show', $pedido) }}" 
                                       class="btn btn-sm btn-info" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Nenhum pedido encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 