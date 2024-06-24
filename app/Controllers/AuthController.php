<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class AuthController extends ResourceController
{
    public function __construct()
    {
        helper('jwt');
    }

    public function login()
    {
        $data = $this->request->getJSON(true);

        $cpf_cnpj = $data['cpf_cnpj'] ?? null;
        $password = $data['password'] ?? null;

        // Carregar o modelo de cliente
        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->where('cpf_cnpj', $cpf_cnpj)->first();

        if ($cliente && password_verify($password, $cliente['password'])) {
            $userData = [
                'id' => $cliente['id'],
                'cpf_cnpj' => $cliente['cpf_cnpj'],
                'nome_razao_social' => $cliente['nome_razao_social']
            ];

            $token = generateJWT($userData);

            return $this->respond([
                'status' => 200,
                'message' => 'Login realizado com sucesso',
                'token' => $token
            ]);
        } else {
            return $this->respond([
                'status' => 401,
                'message' => 'Credenciais inválidas'
            ]);
        }
    }
}
