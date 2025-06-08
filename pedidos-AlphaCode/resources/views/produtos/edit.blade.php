@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Editar Produto</h1>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('produtos.update', $produto) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nome_produto" class="form-label">Nome</label>
                    <input type="text" class="form-control @error('nome_produto') is-invalid @enderror" id="nome_produto" name="nome_produto" value="{{ old('nome_produto', $produto->nome_produto) }}" required>
                    @error('nome_produto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" rows="3" required>{{ old('descricao', $produto->descricao) }}</textarea>
                    @error('descricao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="valor_unitario" class="form-label">Preço</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="number" class="form-control @error('valor_unitario') is-invalid @enderror" id="valor_unitario" name="valor_unitario" value="{{ old('valor_unitario', $produto->valor_unitario) }}" step="0.01" min="0" required>
                                @error('valor_unitario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="quantidade" class="form-label">Estoque</label>
                            <input type="number" class="form-control @error('quantidade') is-invalid @enderror" id="quantidade" name="quantidade" value="{{ old('quantidade', $produto->quantidade) }}" min="0" required>
                            @error('quantidade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
