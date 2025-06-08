@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ isset($cliente) ? 'Editar Cliente' : 'Novo Cliente' }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ isset($cliente) ? route('clientes.update', $cliente) : route('clientes.store') }}" 
              method="POST">
            @csrf
            @if(isset($cliente))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="nomeCliente" class="form-label">Nome</label>
                <input type="text" class="form-control @error('nomeCliente') is-invalid @enderror" 
                       id="nomeCliente" name="nomeCliente" 
                       value="{{ old('nomeCliente', $cliente->nomeCliente ?? '') }}" required>
                @error('nomeCliente')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" class="form-control @error('cpf') is-invalid @enderror" 
                       id="cpf" name="cpf" 
                       value="{{ old('cpf', $cliente->cpf ?? '') }}" required>
                @error('cpf')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" 
                       value="{{ old('email', $cliente->email ?? '') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    {{ isset($cliente) ? 'Atualizar' : 'Criar' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Máscara para CPF
    document.getElementById('cpf').addEventListener('input', function (e) {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,3})(\d{0,2})/);
        e.target.value = !x[2] ? x[1] : x[1] + x[2] + (x[3] ? x[3] : '');
    });
</script>
@endpush 