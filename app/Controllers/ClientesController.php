<?php

namespace App\Controllers;

use App\Repositories\ClienteRepository;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class ClientesController extends ResourceController
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new ClienteRepository();
    }

    public function index()
    {
        try {
            $clientes = $this->repository->findAll();
            return $this->respond([
                'cabecalho' => [
                    'status' => 200,
                    'mensagem' => 'Lista de clientes retornada com sucesso'
                ],
                'retorno' => $clientes
            ]);
        } catch (Exception $e) {
            return $this->respond([
                'cabecalho' => [
                    'status' => 500,
                    'mensagem' => $e->getMessage()
                ],
                'retorno' => []
            ]);
        }
    }

    public function show($id = null)
    {
        try {
            $cliente = $this->repository->find($id);
            if (!$cliente) {
                return $this->respond([
                    'cabecalho' => [
                        'status' => 404,
                        'mensagem' => 'Cliente não encontrado'
                    ],
                    'retorno' => []
                ]);
            }
            return $this->respond([
                'cabecalho' => [
                    'status' => 200,
                    'mensagem' => 'Cliente retornado com sucesso'
                ],
                'retorno' => $cliente
            ]);
        } catch (Exception $e) {
            return $this->respond([
                'cabecalho' => [
                    'status' => 500,
                    'mensagem' => $e->getMessage()
                ],
                'retorno' => []
            ]);
        }
    }

    public function create()
    {
        try {
            $data = $this->request->getJSON(true);
            if (empty($data) || !isset($data['parametros'])) {
                return $this->respond([
                    'cabecalho' => [
                        'status' => 400,
                        'mensagem' => 'Nenhum dado fornecido ou formato incorreto'
                    ],
                    'retorno' => []
                ]);
            }

            $dados = $data['parametros'];
            $result = $this->repository->insert($dados);
            if (isset($result['errors'])) {
                return $this->respond([
                    'cabecalho' => [
                        'status' => 422,
                        'mensagem' => 'Erro na validação dos dados'
                    ],
                    'retorno' => $result['errors']
                ]);
            }

            $insertedData = $this->repository->find($result);

            return $this->respond([
                'cabecalho' => [
                    'status' => 200,
                    'mensagem' => 'Cliente cadastrado com sucesso'
                ],
                'retorno' => $insertedData
            ]);
        } catch (Exception $e) {
            return $this->respond([
                'cabecalho' => [
                    'status' => 500,
                    'mensagem' => $e->getMessage()
                ],
                'retorno' => []
            ]);
        }
    }

    public function update($id = null)
    {
        try {
            $data = $this->request->getJSON(true);
            if (empty($data) || !isset($data['parametros'])) {
                return $this->respond([
                    'cabecalho' => [
                        'status' => 400,
                        'mensagem' => 'Nenhum dado fornecido ou formato incorreto'
                    ],
                    'retorno' => []
                ]);
            }

            $dados = $data['parametros'];
            $result = $this->repository->update($id, $dados);
            if (isset($result['errors'])) {
                return $this->respond([
                    'cabecalho' => [
                        'status' => 422,
                        'mensagem' => 'Erro na validação dos dados'
                    ],
                    'retorno' => $result['errors']
                ]);
            }

            $updatedData = $this->repository->find($id);

            return $this->respond([
                'cabecalho' => [
                    'status' => 200,
                    'mensagem' => 'Cliente atualizado com sucesso'
                ],
                'retorno' => $updatedData
            ]);
        } catch (Exception $e) {
            return $this->respond([
                'cabecalho' => [
                    'status' => 500,
                    'mensagem' => $e->getMessage()
                ],
                'retorno' => []
            ]);
        }
    }

    public function delete($id = null)
    {
        try {
            $this->repository->delete($id);
            return $this->respond([
                'cabecalho' => [
                    'status' => 200,
                    'mensagem' => 'Cliente deletado com sucesso'
                ],
                'retorno' => []
            ]);
        } catch (Exception $e) {
            return $this->respond([
                'cabecalho' => [
                    'status' => 500,
                    'mensagem' => $e->getMessage()
                ],
                'retorno' => []
            ]);
        }
    }
}
