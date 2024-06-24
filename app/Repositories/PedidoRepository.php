<?php

namespace App\Repositories;

use App\Models\PedidoModel;
use App\Models\PedidoItemModel;
use App\Models\ProdutoModel;

class PedidoRepository
{
    protected $model;
    protected $itemModel;
    protected $produtoModel;

    public function __construct()
    {
        $this->model = new PedidoModel();
        $this->itemModel = new PedidoItemModel();
        $this->produtoModel = new ProdutoModel();
    }

    public function findAll($limit = 10, $offset = 0, $filters = [])
    {
        $query = $this->model;

        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                $query = $query->like($key, $value);
            }
        }

        return $query->findAll($limit, $offset);
    }

    public function find($id)
    {
        $pedido = $this->model->find($id);
        if ($pedido) {
            $pedido['itens'] = $this->itemModel->where('pedido_id', $id)->findAll();
        }
        return $pedido;
    }

    public function insert($data)
    {
        $valorTotal = 0;
        if (isset($data['itens']) && is_array($data['itens'])) {
            foreach ($data['itens'] as $item) {
                $produto = $this->produtoModel->find($item['produto_id']);
                if ($produto) {
                    $valorTotal += $produto['preco'] * $item['quantidade'];
                }
            }
        }
        $data['valor_total'] = $valorTotal;

        if (!$this->model->validate($data)) {
            return ['errors' => $this->model->errors()];
        }
        $this->model->db->transStart();
        $pedidoId = $this->model->insert($data);
        if (isset($data['itens']) && is_array($data['itens'])) {
            foreach ($data['itens'] as $item) {
                $item['pedido_id'] = $pedidoId;
                if (!$this->itemModel->validate($item)) {
                    return ['errors' => $this->itemModel->errors()];
                }
                $this->itemModel->insert($item);
            }
        }
        $this->model->db->transComplete();
        return $pedidoId;
    }

    public function update($id, $data)
    {
        if (isset($data['itens']) && is_array($data['itens'])) {
            $valorTotal = 0;
            foreach ($data['itens'] as $item) {
                $produto = $this->produtoModel->find($item['produto_id']);
                if ($produto) {
                    $valorTotal += $produto['preco'] * $item['quantidade'];
                }
            }
            $data['valor_total'] = $valorTotal;
        }

        if (!$this->model->validate($data)) {
            return ['errors' => $this->model->errors()];
        }
        $this->model->db->transStart();
        $this->model->update($id, $data);
        if (isset($data['itens']) && is_array($data['itens'])) {
            $this->itemModel->where('pedido_id', $id)->delete();
            foreach ($data['itens'] as $item) {
                $item['pedido_id'] = $id;
                if (!$this->itemModel->validate($item)) {
                    return ['errors' => $this->itemModel->errors()];
                }
                $this->itemModel->insert($item);
            }
        }
        $this->model->db->transComplete();
        return $id;
    }

    public function delete($id)
    {
        $this->model->db->transStart();
        $this->itemModel->where('pedido_id', $id)->delete();
        $this->model->delete($id);
        $this->model->db->transComplete();
        return $id;
    }
}
