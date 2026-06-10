<?php

namespace App\Repositories;

abstract class BaseEloquentRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = app()->make($this->model());
    }

    abstract public function model();

    public function all()
    {
        return $this->model->all();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->findById($id);

        if ($record) {
            $record->update($data);
        }

        return $record;
    }

    public function delete($id)
    {
        $record = $this->findById($id);

        if ($record) {
            return $record->delete();
        }

        return false;
    }

    public function findWhere(array $conditions)
    {
        return $this->model->where($conditions)->get();
    }
}