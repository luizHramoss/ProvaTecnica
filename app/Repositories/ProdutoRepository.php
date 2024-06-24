<?php

namespace App\Repositories;

use App\Models\ProdutoModel;

class ProdutoRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new ProdutoModel();
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
        return $this->model->find($id);
    }

    public function insert($data)
    {
        if (!$this->model->validate($data)) {
            return ['errors' => $this->model->errors()];
        }
        $id = $this->model->insert($data);
        return $id ? $id : ['errors' => 'Failed to insert data'];
    }

    public function update($id, $data)
    {
        if (!$this->model->validate($data)) {
            return ['errors' => $this->model->errors()];
        }
        $updated = $this->model->update($id, $data);
        return $updated ? $id : ['errors' => 'Failed to update data'];
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }
}
