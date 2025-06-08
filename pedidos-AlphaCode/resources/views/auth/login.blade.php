@extends('layouts.app')

@section('content')
<div class="text-center">
    <div class="mb-4">
        <h2 class="text-white">{{ config('app.name', 'Laravel') }}</h2>
        <p class="text-white-50">Faça login para acessar o sistema</p>
    </div>
    <div class="card" style="width: 400px; margin: 0 auto;">
        <div class="card-body p-4">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="text-start">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-envelope text-primary"></i>
                        </span>
                        <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" 
                            id="email" name="email" value="{{ old('email') }}" required autofocus>
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

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Lembrar-me</label>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-box-arrow-in-right"></i> Entrar
                    </button>
                </div>
            </form>

            <div class="mt-4">
                <p class="mb-0">Não tem uma conta? <a href="{{ route('register') }}" class="text-primary text-decoration-none">Cadastre-se</a></p>
            </div>
        </div>
    </div>
</div>
@endsection 