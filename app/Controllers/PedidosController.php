<?php

namespace App\Controllers;

use App\Repositories\PedidoRepository;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class PedidosController extends ResourceController
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new PedidoRepository();
    }

    public function index()
    {
        try {
            $pedidos = $this->repository->findAll();
            return $this->respond([
                'cabecalho' => [
                    'status' => 200,
                    'mensagem' => 'Lista de pedidos retornada com sucesso'
                ],
                'retorno' => $pedidos
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
            $pedido = $this->repository->find($id);
            if (!$pedido) {
                return $this->respond([
                    'cabecalho' => [
                        'status' => 404,
                        'mensagem' => 'Pedido não encontrado'
                    ],
                    'retorno' => []
                ]);
            }
            return $this->respond([
                'cabecalho' => [
                    'status' => 200,
                    'mensagem' => 'Pedido retornado com sucesso'
                ],
                'retorno' => $pedido
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

            // Definindo o status como "Em Aberto"
            $dados = $data['parametros'];
            $dados['status'] = 'Em Aberto';

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

            // Retrieve the inserted data
            $insertedData = $this->repository->find($result);

            return $this->respondCreated([
                'cabecalho' => [
                    'status' => 200,
                    'mensagem' => 'Pedido cadastrado com sucesso'
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

            // Permitindo apenas a atualização do status
            $dados = $data['parametros'];
            if (isset($dados['status']) && in_array($dados['status'], ['Pago', 'Cancelado'])) {
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

                // Retrieve the updated data
                $updatedData = $this->repository->find($id);

                return $this->respond([
                    'cabecalho' => [
                        'status' => 200,
                        'mensagem' => 'Pedido atualizado com sucesso'
                    ],
                    'retorno' => $updatedData
                ]);
            } else {
                return $this->respond([
                    'cabecalho' => [
                        'status' => 422,
                        'mensagem' => 'Status inválido.'
                    ],
                    'retorno' => []
                ]);
            }
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
            $pedido = $this->repository->find($id);

            if (!$pedido) {
                return $this->respond([
                    'cabecalho' => [
                        'status' => 404,
                        'mensagem' => 'Pedido não encontrado'
                    ],
                    'retorno' => []
                ]);
            }

            if ($pedido['status'] == 'Pago') {
                return $this->respond([
                    'cabecalho' => [
                        'status' => 403,
                        'mensagem' => 'Não é permitido deletar pedidos pagos'
                    ],
                    'retorno' => []
                ]);
            }

            $this->repository->delete($id);
            return $this->respondDeleted([
                'cabecalho' => [
                    'status' => 200,
                    'mensagem' => 'Pedido deletado com sucesso'
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
