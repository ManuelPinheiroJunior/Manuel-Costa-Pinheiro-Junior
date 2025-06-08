@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Editar Pedido</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="cliente_id" class="form-label">Cliente</label>
                                <select name="cliente_id" id="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                                    <option value="">Selecione um cliente</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ $pedido->cliente_id == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nomeCliente }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cliente_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="dt_pedido" class="form-label">Data do Pedido</label>
                                <input type="datetime-local" class="form-control @error('dt_pedido') is-invalid @enderror" 
                                    id="dt_pedido" name="dt_pedido" value="{{ old('dt_pedido', $pedido->dt_pedido->format('Y-m-d\TH:i')) }}" required>
                                @error('dt_pedido')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="Em Aberto" {{ $pedido->status == 'Em Aberto' ? 'selected' : '' }}>Em Aberto</option>
                                    <option value="Pago" {{ $pedido->status == 'Pago' ? 'selected' : '' }}>Pago</option>
                                    <option value="Cancelado" {{ $pedido->status == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Produtos</h6>
                            </div>
                            <div class="card-body">
                                <div id="produtos-container">
                                    @foreach($pedido->itens as $index => $item)
                                    <div class="row mb-3 produto-item">
                                        <div class="col-md-4">
                                            <label class="form-label">Produto</label>
                                            <select name="produtos[{{ $index }}][produto_id]" class="form-select produto-select" required>
                                                <option value="">Selecione um produto</option>
                                                @foreach($produtos as $produto)
                                                    <option value="{{ $produto->id }}" 
                                                        data-preco="{{ $produto->preco }}"
                                                        {{ $item->produto_id == $produto->id ? 'selected' : '' }}>
                                                        {{ $produto->nomeProduto }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Quantidade</label>
                                            <input type="number" name="produtos[{{ $index }}][quantidade]" 
                                                class="form-control quantidade" min="1" 
                                                value="{{ $item->quantidade }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Valor Unitário</label>
                                            <input type="number" step="0.01" name="produtos[{{ $index }}][valor_unitario]" 
                                                class="form-control valor-unitario" min="0" 
                                                value="{{ $item->valor_unitario }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Subtotal</label>
                                            <input type="text" class="form-control subtotal" readonly 
                                                value="R$ {{ number_format($item->quantidade * $item->valor_unitario, 2, ',', '.') }}">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            @if($index > 0)
                                            <button type="button" class="btn btn-danger remover-produto">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-success" id="adicionar-produto">
                                    <i class="bi bi-plus"></i> Adicionar Produto
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Total do Pedido</label>
                                    <input type="text" class="form-control" id="total" readonly 
                                        value="R$ {{ number_format($pedido->itens->sum(function($item) {
                                            return $item->quantidade * $item->valor_unitario;
                                        }), 2, ',', '.') }}">
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const produtosContainer = document.getElementById('produtos-container');
    const adicionarProdutoBtn = document.getElementById('adicionar-produto');
    const produtos = @json($produtos);

    function atualizarSubtotal(item) {
        const quantidade = parseFloat(item.querySelector('.quantidade').value) || 0;
        const valorUnitario = parseFloat(item.querySelector('.valor-unitario').value) || 0;
        const subtotal = quantidade * valorUnitario;
        item.querySelector('.subtotal').value = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
        atualizarTotal();
    }

    function atualizarTotal() {
        const subtotais = Array.from(document.querySelectorAll('.subtotal')).map(input => {
            return parseFloat(input.value.replace('R$ ', '').replace(',', '.')) || 0;
        });
        const total = subtotais.reduce((a, b) => a + b, 0);
        document.getElementById('total').value = `R$ ${total.toFixed(2).replace('.', ',')}`;
    }

    function setupEventListeners(item) {
        const quantidadeInput = item.querySelector('.quantidade');
        const valorUnitarioInput = item.querySelector('.valor-unitario');
        const produtoSelect = item.querySelector('.produto-select');
        const removerBtn = item.querySelector('.remover-produto');

        quantidadeInput.addEventListener('input', () => atualizarSubtotal(item));
        valorUnitarioInput.addEventListener('input', () => atualizarSubtotal(item));

        produtoSelect.addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            const preco = parseFloat(option.dataset.preco) || 0;
            valorUnitarioInput.value = preco.toFixed(2);
            atualizarSubtotal(item);
        });

        if (removerBtn) {
            removerBtn.addEventListener('click', function() {
                item.remove();
                atualizarTotal();
            });
        }
    }

    adicionarProdutoBtn.addEventListener('click', function() {
        const index = document.querySelectorAll('.produto-item').length;
        const template = `
            <div class="row mb-3 produto-item">
                <div class="col-md-4">
                    <label class="form-label">Produto</label>
                    <select name="produtos[${index}][produto_id]" class="form-select produto-select" required>
                        <option value="">Selecione um produto</option>
                        ${produtos.map(produto => `
                            <option value="${produto.id}" data-preco="${produto.preco}">
                                ${produto.nomeProduto}
                            </option>
                        `).join('')}
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Quantidade</label>
                    <input type="number" name="produtos[${index}][quantidade]" 
                        class="form-control quantidade" min="1" value="1" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Valor Unitário</label>
                    <input type="number" step="0.01" name="produtos[${index}][valor_unitario]" 
                        class="form-control valor-unitario" min="0" value="0.00" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Subtotal</label>
                    <input type="text" class="form-control subtotal" readonly value="R$ 0,00">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remover-produto">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;

        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = template;
        const newItem = tempDiv.firstElementChild;
        produtosContainer.appendChild(newItem);
        setupEventListeners(newItem);
    });

    // Configurar event listeners para os itens existentes
    document.querySelectorAll('.produto-item').forEach(setupEventListeners);
});
</script>
@endpush 