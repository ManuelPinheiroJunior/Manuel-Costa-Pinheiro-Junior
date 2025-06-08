@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Editar Cliente</h5>
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nomeCliente" class="form-label">Nome</label>
                            <input type="text" class="form-control @error('nomeCliente') is-invalid @enderror" 
                                   id="nomeCliente" name="nomeCliente" 
                                   value="{{ old('nomeCliente', $cliente->nomeCliente) }}" required>
                            @error('nomeCliente')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control @error('cpf') is-invalid @enderror" 
                                   id="cpf" name="cpf" 
                                   value="{{ old('cpf', $cliente->cpf) }}" 
                                   placeholder="000.000.000-00" maxlength="14" required>
                            @error('cpf')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" 
                                   value="{{ old('email', $cliente->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" class="form-control @error('telefone') is-invalid @enderror" 
                                   id="telefone" name="telefone" 
                                   value="{{ old('telefone', $cliente->telefone) }}" required>
                            @error('telefone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input type="text" class="form-control @error('endereco') is-invalid @enderror" 
                                   id="endereco" name="endereco" 
                                   value="{{ old('endereco', $cliente->endereco) }}" required>
                            @error('endereco')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cidade" class="form-label">Cidade</label>
                                    <input type="text" class="form-control @error('cidade') is-invalid @enderror" 
                                           id="cidade" name="cidade" 
                                           value="{{ old('cidade', $cliente->cidade) }}" required>
                                    @error('cidade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <input type="text" class="form-control @error('estado') is-invalid @enderror" 
                                           id="estado" name="estado" 
                                           value="{{ old('estado', $cliente->estado) }}" 
                                           maxlength="2" required>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="text" class="form-control @error('cep') is-invalid @enderror" 
                                           id="cep" name="cep" 
                                           value="{{ old('cep', $cliente->cep) }}" 
                                           maxlength="9" required>
                                    @error('cep')
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
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cpfInput = document.getElementById('cpf');
    const cepInput = document.getElementById('cep');
    const telefoneInput = document.getElementById('telefone');
    
    // Formatação do CPF
    cpfInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length <= 11) {
            value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            value = value.replace(/(\d{3})(\d{3})(\d{3})/, '$1.$2.$3');
            value = value.replace(/(\d{3})(\d{3})/, '$1.$2');
        }
        
        e.target.value = value;
    });

    // Formatação do CEP
    cepInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length <= 8) {
            value = value.replace(/(\d{5})(\d{3})/, '$1-$2');
        }
        
        e.target.value = value;
    });

    // Formatação do Telefone
    telefoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length <= 11) {
            value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
        }
        
        e.target.value = value;
    });
});
</script>
@endpush

@endsection 