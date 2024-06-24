<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoItemModel extends Model
{
    protected $table = 'pedido_itens';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pedido_id', 'produto_id', 'quantidade'];
    protected $returnType = 'array';
    protected $useTimestamps = true;

    protected $validationRules = [
        'pedido_id' => 'required|integer',
        'produto_id' => 'required|integer',
        'quantidade' => 'required|integer|greater_than[0]',
    ];

    protected $validationMessages = [
        'pedido_id' => [
            'required' => 'O campo Pedido ID é obrigatório.',
            'integer' => 'O campo Pedido ID deve ser um número inteiro.'
        ],
        'produto_id' => [
            'required' => 'O campo Produto ID é obrigatório.',
            'integer' => 'O campo Produto ID deve ser um número inteiro.'
        ],
        'quantidade' => [
            'required' => 'O campo Quantidade é obrigatório.',
            'integer' => 'O campo Quantidade deve ser um número inteiro.',
            'greater_than' => 'O campo Quantidade deve ser maior que zero.'
        ]
    ];
}

