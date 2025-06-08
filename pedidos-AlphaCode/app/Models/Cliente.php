<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nomeCliente',
        'telefone',
        'endereco',
        'cidade',
        'estado',
        'cep',
        'cpf',
        'email'
    ];

    public $timestamps = true;

    public static function rules()
    {
        return [
            'nomeCliente' => 'required|string|max:100',
            'telefone'=> 'string|nullable|max:15|regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/',
            'endereco'=> 'string|nullable|max:255',
            'cidade'=> 'string|nullable|max:100',
            'estado'=> 'string|nullable|max:2',
            'cep'=> 'string|nullable|max:9|regex:/^\d{5}-?\d{3}$/',
            'cpf' => 'required|size:11|unique:clientes|regex:/^[0-9]{11}$/',
            'email' => 'nullable|email|max:100|unique:clientes'
        ];
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
