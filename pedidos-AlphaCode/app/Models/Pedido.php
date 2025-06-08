<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    
    const STATUS_ABERTO = 'Em Aberto';
    const STATUS_PAGO = 'Pago';
    const STATUS_CANCELADO = 'Cancelado';

    protected $fillable = [
        'cliente_id',
        'dt_pedido',
        'status'
    ];

    public $timestamps = true;

    protected $casts = [
        'dt_pedido' => 'datetime'
    ];

    public static function rules()
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'dt_pedido' => 'required|date|before_or_equal:now',
            'status' => 'required|in:' . implode(',', [
                self::STATUS_ABERTO,
                self::STATUS_PAGO,
                self::STATUS_CANCELADO
            ])
        ];
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function itens()
    {
        return $this->hasMany(PedidoItem::class);
    }

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'pedido_itens')
            ->withPivot(['quantidade', 'valor_unitario'])
            ->withTimestamps();
    }

    public function getTotalAttribute()
    {
        return $this->itens->sum(function($item) {
            return $item->quantidade * $item->valor_unitario;
        });
    }
}