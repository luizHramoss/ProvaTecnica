<?php

namespace App\Repositories;

use App\Models\ClienteModel;

class ClienteRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new ClienteModel();
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

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findAll()
    {
        return $this->model->findAll();
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }
}
