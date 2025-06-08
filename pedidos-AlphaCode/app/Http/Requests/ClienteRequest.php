<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nomeCliente' => 'required|string|max:255',
            'cpf' => [
                'required',
                'string',
                'regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
                'unique:clientes,cpf,' . ($this->cliente ? $this->cliente->id : 'NULL') . ',id'
            ],
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:20',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|max:2',
            'cep' => 'required|string|max:9'
        ];
    }

    public function messages(): array
    {
        return [
            'nomeCliente.required' => 'O nome do cliente é obrigatório',
            'cpf.required' => 'O CPF é obrigatório',
            'cpf.regex' => 'O CPF deve estar no formato XXX.XXX.XXX-XX',
            'cpf.unique' => 'Este CPF já está cadastrado',
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'Digite um e-mail válido',
            'telefone.required' => 'O telefone é obrigatório',
            'endereco.required' => 'O endereço é obrigatório',
            'cidade.required' => 'A cidade é obrigatória',
            'estado.required' => 'O estado é obrigatório',
            'cep.required' => 'O CEP é obrigatório'
        ];
    }
} 