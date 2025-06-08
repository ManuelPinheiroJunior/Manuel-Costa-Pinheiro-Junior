<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total de pedidos
        $totalPedidos = Pedido::count();

        // Pedidos por status
        $pedidosEmAberto = Pedido::where('status', 'Em Aberto')->count();
        $pedidosPagos = Pedido::where('status', 'Pago')->count();
        $pedidosCancelados = Pedido::where('status', 'Cancelado')->count();

        // Labels e dados para o gráfico de status
        $statusLabels = ['Em Aberto', 'Pago', 'Cancelado'];
        $statusData = [$pedidosEmAberto, $pedidosPagos, $pedidosCancelados];

        // Pedidos por mês (últimos 6 meses)
        $pedidosPorMes = Pedido::selectRaw('to_char(dt_pedido, \'Month/YYYY\') as mes, COUNT(*) as total, MAX(dt_pedido) as ultima_data')
            ->groupBy('mes')
            ->orderBy('ultima_data', 'desc')
            ->limit(6)
            ->get();

        // Últimos pedidos
        $ultimosPedidos = Pedido::with(['cliente', 'itens.produto'])
            ->orderBy('dt_pedido', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalPedidos',
            'pedidosEmAberto',
            'pedidosPagos',
            'pedidosCancelados',
            'statusLabels',
            'statusData',
            'pedidosPorMes',
            'ultimosPedidos'
        ));
    }
} 