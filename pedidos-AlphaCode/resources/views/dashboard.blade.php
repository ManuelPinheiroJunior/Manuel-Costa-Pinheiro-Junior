@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total de Pedidos</h6>
                            <h2 class="mt-2 mb-0">{{ $totalPedidos }}</h2>
                        </div>
                        <i class="bi bi-cart fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Pedidos Em Aberto</h6>
                            <h2 class="mt-2 mb-0">{{ $pedidosEmAberto }}</h2>
                        </div>
                        <i class="bi bi-clock fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Pedidos Pagos</h6>
                            <h2 class="mt-2 mb-0">{{ $pedidosPagos }}</h2>
                        </div>
                        <i class="bi bi-check-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Pedidos Cancelados</h6>
                            <h2 class="mt-2 mb-0">{{ $pedidosCancelados }}</h2>
                        </div>
                        <i class="bi bi-x-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Pedidos por Status</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <div style="width: 300px; height: 300px;">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Pedidos por Mês</h5>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="pedidosMesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Últimos Pedidos</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Data</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ultimosPedidos as $pedido)
                                <tr>
                                    <td>{{ $pedido->id }}</td>
                                    <td>{{ $pedido->cliente->nomeCliente }}</td>
                                    <td>{{ $pedido->dt_pedido->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $pedido->status === 'Pago' ? 'success' : ($pedido->status === 'Em Aberto' ? 'warning' : 'danger') }}">
                                            {{ $pedido->status }}
                                        </span>
                                    </td>
                                    <td>
                                        R$ {{ number_format($pedido->itens->sum(function($item) {
                                            return $item->quantidade * $item->valor_unitario;
                                        }), 2, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de Status
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($statusLabels) !!},
            datasets: [{
                data: {!! json_encode($statusData) !!},
                backgroundColor: [
                    '#ffc107', // Em Aberto (warning)
                    '#198754', // Pago (success)
                    '#dc3545'  // Cancelado (danger)
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Gráfico de Pedidos por Mês
    const pedidosMesCtx = document.getElementById('pedidosMesChart').getContext('2d');
    const pedidosPorMes = {!! json_encode($pedidosPorMes) !!};
    
    new Chart(pedidosMesCtx, {
        type: 'bar',
        data: {
            labels: pedidosPorMes.map(item => traduzirMes(item.mes)),
            datasets: [{
                label: 'Total de Pedidos',
                data: pedidosPorMes.map(item => item.total),
                backgroundColor: '#0d6efd',
                borderColor: '#0d6efd',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});

// Função para traduzir os meses
function traduzirMes(mes) {
    const meses = {
        'January': 'Janeiro',
        'February': 'Fevereiro',
        'March': 'Março',
        'April': 'Abril',
        'May': 'Maio',
        'June': 'Junho',
        'July': 'Julho',
        'August': 'Agosto',
        'September': 'Setembro',
        'October': 'Outubro',
        'November': 'Novembro',
        'December': 'Dezembro'
    };
    
    // Remove o ano e espaços extras
    const mesSemAno = mes.split('/')[0].trim();
    return meses[mesSemAno] || mesSemAno;
}
</script>
@endpush 