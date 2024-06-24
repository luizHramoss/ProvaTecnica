<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['cliente_id', 'status', 'valor_total'];
    protected $returnType = 'array';
    protected $useTimestamps = true;

    protected $validationRules = [
        'cliente_id' => 'required|integer',
        'status' => 'required|in_list[Em Aberto,Pago,Cancelado]',
        'valor_total' => 'decimal'
    ];

    protected $validationMessages = [
        'cliente_id' => [
            'required' => 'O campo Cliente ID é obrigatório.',
            'integer' => 'O campo Cliente ID deve ser um número inteiro.'
        ],
        'status' => [
            'required' => 'O campo Status é obrigatório.',
            'in_list' => 'O campo Status deve ser um dos seguintes: Em Aberto, Pago, Cancelado.'
        ],
        'valor_total' => [
            'decimal' => 'O campo Valor Total deve ser um valor decimal.'
        ]
    ];
}

