<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table = 'produtos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome', 'preco'];
    protected $returnType = 'array';
    protected $useTimestamps = true;

    protected $validationRules = [
        'nome' => 'required|min_length[3]|max_length[255]',
        'preco' => 'required|decimal',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo Nome é obrigatório.',
            'min_length' => 'O campo Nome deve ter pelo menos 3 caracteres.',
            'max_length' => 'O campo Nome não pode exceder 255 caracteres.'
        ],
        'preco' => [
            'required' => 'O campo Preço é obrigatório.',
            'decimal' => 'O campo Preço deve ser um valor decimal.'
        ]
    ];
}

