@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Detalhes do Produto</h1>
            <div>
                <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="{{ route('produtos.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="card-title">Informações Básicas</h5>
                        <table class="table">
                            <tr>
                                <th style="width: 150px;">ID:</th>
                                <td>{{ $produto->id }}</td>
                            </tr>
                            <tr>
                                <th>Nome:</th>
                                <td>{{ $produto->nome_produto }}</td>
                            </tr>
                            <tr>
                                <th>Descrição:</th>
                                <td>{{ $produto->descricao }}</td>
                            </tr>
                            <tr>
                                <th>Preço:</th>
                                <td>R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Estoque:</th>
                                <td>{{ $produto->quantidade }} unidades</td>
                            </tr>
                            <tr>
                                <th>Data de Cadastro:</th>
                                <td>{{ $produto->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Última Atualização:</th>
                                <td>{{ $produto->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    <form action="{{ route('produtos.destroy', $produto) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                            <i class="bi bi-trash"></i> Excluir Produto
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
