@extends('layouts.app')

@section('content')
<div class="text-center">
    <div class="mb-4">
        <h2 class="text-white">{{ config('app.name', 'Laravel') }}</h2>
        <p class="text-white-50">Crie sua conta para acessar o sistema</p>
    </div>
    <div class="card" style="width: 400px; margin: 0 auto;">
        <div class="card-body p-4">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="text-start">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-person text-primary"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" 
                            id="name" name="name" value="{{ old('name') }}" required autofocus>
                    </div>
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-envelope text-primary"></i>
                        </span>
                        <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" 
                            id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-lock text-primary"></i>
                        </span>
                        <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" 
                            id="password" name="password" required>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-lock text-primary"></i>
                        </span>
                        <input type="password" class="form-control border-start-0" 
                            id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-person-plus"></i> Cadastrar
                    </button>
                </div>
            </form>

            <div class="mt-4">
                <p class="mb-0">Já tem uma conta? <a href="{{ route('login') }}" class="text-primary text-decoration-none">Faça login</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
