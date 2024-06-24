<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['cpf_cnpj', 'nome_razao_social', 'password'];
    protected $returnType = 'array';
    protected $useTimestamps = true;

    protected $validationRules = [
        'cpf_cnpj' => 'required|cpfCnpj',
        'nome_razao_social' => 'required|min_length[3]|max_length[255]',
        'password' => 'required|min_length[8]',
    ];

    protected $validationMessages = [
        'cpf_cnpj' => [
            'required' => 'O campo CPF/CNPJ é obrigatório.',
            'cpfCnpj' => 'O campo CPF/CNPJ deve ser válido.'
        ],
        'nome_razao_social' => [
            'required' => 'O campo Nome/Razão Social é obrigatório.',
            'min_length' => 'O campo Nome/Razão Social deve ter pelo menos 3 caracteres.',
            'max_length' => 'O campo Nome/Razão Social não pode exceder 255 caracteres.'
        ],
        'password' => [
            'required' => 'O campo Senha é obrigatório.',
            'min_length' => 'O campo Senha deve ter pelo menos 8 caracteres.'
        ]
    ];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }
}
