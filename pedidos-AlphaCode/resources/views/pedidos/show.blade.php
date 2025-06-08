@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detalhes do Pedido #{{ $pedido->id }}</h5>
                    <div>
                        <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-primary me-2">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Informações do Cliente -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2">Informações do Cliente</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nome:</strong> {{ $pedido->cliente->nomeCliente }}</p>
                                <p><strong>CPF:</strong> {{ $pedido->cliente->cpf }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Data do Pedido:</strong> {{ $pedido->dt_pedido->format('d/m/Y H:i') }}</p>
                                <p><strong>Status:</strong> 
                                    <span class="badge bg-{{ $pedido->status === 'Em Aberto' ? 'warning' : ($pedido->status === 'Pago' ? 'success' : 'danger') }}">
                                        {{ $pedido->status }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Produtos do Pedido -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2">Produtos</h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th class="text-center">Quantidade</th>
                                        <th class="text-end">Valor Unitário</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach($pedido->itens as $item)
                                        @php
                                            $subtotal = $item->quantidade * $item->valor_unitario;
                                            $total += $subtotal;
                                        @endphp
                                        <tr>
                                            <td>{{ $item->produto->nome_produto }}</td>
                                            <td class="text-center">{{ $item->quantidade }}</td>
                                            <td class="text-end">R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</td>
                                            <td class="text-end">R$ {{ number_format($subtotal, 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Total:</th>
                                        <th class="text-end">R$ {{ number_format($total, 2, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Histórico -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2">Histórico</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Criado em:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Última atualização:</strong> {{ $pedido->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 