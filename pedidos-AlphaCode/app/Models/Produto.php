<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';

    protected $fillable = [
        'cod_barras',
        'nome_produto',
        'descricao',
        'valor_unitario',
        'quantidade',
    ];

    public $timestamps = true;

    protected $casts = [
        'valor_unitario' => 'decimal:2'
    ];

    public static function rules()
    {
        return [
            'cod_barras' => 'required|string|max:20|unique:produtos|regex:/^[0-9]{8,20}$/',
            'nome_produto' => 'nullable|string|max:100',
            'descricao' => 'string|min:0',
            'valor_unitario' => 'required|numeric|min:0'
        ];
    }

    public function pedidoItens()
    {
        return $this->hasMany(PedidoItem::class);
    }
}
