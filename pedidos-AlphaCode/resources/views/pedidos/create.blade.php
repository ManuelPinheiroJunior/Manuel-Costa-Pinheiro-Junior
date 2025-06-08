@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Novo Pedido</h5>
                    <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('pedidos.store') }}" method="POST" id="pedidoForm">
                        @csrf

                        <!-- Cliente -->
                        <div class="mb-4">
                            <label for="cliente_id" class="form-label">Cliente</label>
                            <select name="cliente_id" id="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                                <option value="">Selecione um cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nomeCliente }} - CPF: {{ $cliente->cpf }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Produtos -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Produtos</h6>
                                <button type="button" class="btn btn-primary btn-sm" id="adicionar-produto">
                                    <i class="bi bi-plus"></i> Adicionar Produto
                                </button>
                            </div>
                            <div id="produtos-container" class="list-group">
                                <div class="list-group-item produto-item">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <select name="produtos[]" class="form-select produto-select" required>
                                                <option value="">Selecione um produto</option>
                                                @foreach($produtos as $produto)
                                                    <option value="{{ $produto->id }}"
                                                        data-preco="{{ $produto->valor_unitario }}"
                                                        data-estoque="{{ $produto->quantidade }}">
                                                        {{ $produto->nome_produto }} - R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}
                                                        (Estoque: {{ $produto->quantidade }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" name="quantidades[]" class="form-control quantidade" placeholder="Qtd" min="1" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" name="valores[]" class="form-control valor" placeholder="Valor" step="0.01" min="0" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control subtotal" readonly>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger remover-produto">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="row mb-4">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text">Total</span>
                                    <input type="text" class="form-control" id="total" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Em Aberto" {{ old('status') == 'Em Aberto' ? 'selected' : '' }}>Em Aberto</option>
                                <option value="Pago" {{ old('status') == 'Pago' ? 'selected' : '' }}>Pago</option>
                                <option value="Cancelado" {{ old('status') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Salvar Pedido
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('produtos-container');
    const btnAdicionar = document.getElementById('adicionar-produto');
    const totalInput = document.getElementById('total');

    if (!container || !btnAdicionar || !totalInput) {
        console.error("Elementos não encontrados:", {
            container: !!container,
            btnAdicionar: !!btnAdicionar,
            totalInput: !!totalInput
        });
        return;
    }

    function adicionarProduto() {
        const primeiroItem = container.querySelector('.produto-item');
        if (!primeiroItem) {
            console.error("Item base não encontrado");
            return;
        }

        const novoItem = primeiroItem.cloneNode(true);

        // Limpa os valores
        novoItem.querySelector('.produto-select').selectedIndex = 0;
        novoItem.querySelector('.quantidade').value = '';
        novoItem.querySelector('.quantidade').removeAttribute('max');
        novoItem.querySelector('.valor').value = '';
        novoItem.querySelector('.subtotal').value = '';

        // Remove validações
        novoItem.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        novoItem.querySelectorAll('.invalid-feedback').forEach(el => {
            el.remove();
        });

        container.appendChild(novoItem);
        setupEventListeners(novoItem);
    }

    function calcularSubtotal(item) {
        const quantidade = parseFloat(item.querySelector('.quantidade').value) || 0;
        const valor = parseFloat(item.querySelector('.valor').value) || 0;
        const subtotal = quantidade * valor;
        item.querySelector('.subtotal').value = subtotal.toFixed(2);
        calcularTotal();
    }

    function calcularTotal() {
        const subtotais = Array.from(document.querySelectorAll('.subtotal'))
            .map(input => parseFloat(input.value) || 0);
        const total = subtotais.reduce((sum, value) => sum + value, 0);
        totalInput.value = total.toFixed(2);
    }

    function setupEventListeners(item) {
        const select = item.querySelector('.produto-select');
        const quantidade = item.querySelector('.quantidade');
        const valor = item.querySelector('.valor');
        const btnRemover = item.querySelector('.remover-produto');

        select.addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            if (option && option.dataset) {
                valor.value = option.dataset.preco || 0;
                quantidade.max = option.dataset.estoque || 9999;
                quantidade.value = 1;
                calcularSubtotal(item);
            }
        });

        quantidade.addEventListener('input', function() {
            const max = parseInt(this.max);
            const value = parseInt(this.value);
            if (value > max) this.value = max;
            if (value < 1) this.value = 1;
            calcularSubtotal(item);
        });

        valor.addEventListener('input', function() {
            if (parseFloat(this.value) < 0) this.value = 0;
            calcularSubtotal(item);
        });

        btnRemover.addEventListener('click', function() {
            if (container.children.length > 1) {
                item.remove();
                calcularTotal();
            }
        });
    }

    // Inicializa os itens já presentes
    container.querySelectorAll('.produto-item').forEach(item => {
        setupEventListeners(item);
        calcularSubtotal(item);
    });

    // Adiciona evento de click ao botão
    btnAdicionar.addEventListener('click', function(e) {

        e.preventDefault();
        adicionarProduto();
    });
});
</script>
@endsection
