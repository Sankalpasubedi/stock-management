<?php

namespace App\Repositories;

use App\Exceptions\CustomException;
use App\Repositories\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{

    //ucwords(implode(' ', preg_split('/(?=[A-Z])/', explode('\\', get_class($this->model))[2]))) . " Not Found"

    //protected Model $model;


    public function __construct(protected Model $model)
    {

    }

    /**
     * @throws CustomException
     */
    public function all(array $cols = null): \Illuminate\Database\Eloquent\Collection
    {
        try {
            return isset($cols) ? $this->model->all($cols) : $this->model->all();
        } catch (\Exception $ex) {
            throw new CustomException("Record Not Found.");
        }
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function insertMany(array $attributes)
    {
        return $this->model->insert($attributes);
    }

    /**
     * @throws CustomException
     * @throws \Throwable
     */
    public function update($id, array $newUpdate, $column = 'id')
    {
        $exists = $this->model->where($column, $id)->exists();
        throw_if(!$exists, new CustomException("Record Not Found."));
        return $this->model->where($column, $id)->update($newUpdate);
    }

    /**
     * @throws CustomException
     * @throws \Throwable
     */
    public function findById($id)
    {
        $exists = $this->model->where('id', $id)->exists();
        throw_if(!$exists, new CustomException("Record Not Found."));
        return $this->model->find($id);
    }

    public function fieldExists($fieldName, $fieldValue)
    {
        return $this->model->where($fieldName, $fieldValue)->exists();
    }

    /**
     * @throws CustomException
     * @throws \Throwable
     */
    public function findByName($name, $value)
    {
        $exists = $this->model->where($name, $value)->exists();
        throw_if(!$exists, new CustomException("Record Not Found."));
        return $this->model->where($name, $value);
    }

    /**
     * @throws CustomException
     * @throws \Throwable
     */
    public function findByNameSelect(array $select, $name, $value)
    {
        $exists = $this->model->where($name, $value)->exists();
        throw_if(!$exists, new CustomException("Record Not Found."));
        return $this->model->select($select)->where($name, $value);
    }

    /**
     * @throws CustomException
     * @throws \Throwable
     */
    public function selectByName($name, $value, array $select)
    {
        $exists = $this->model->where($name, $value)->exists();
        throw_if(!$exists, new CustomException("Record Not Found."));
        return $this->model->select($select)->where($name, $value);
    }

    /**
     * @throws CustomException
     * @throws \Throwable
     */
    public function destroy($id)
    {
        $exists = $this->model->where('id', $id)->exists();
        throw_if(!$exists, new CustomException("Record Not Found."));
        return $this->model->find($id)->delete();
    }

    /**
     * @throws CustomException
     * @throws \Throwable
     */
    public function forceDestroy($id)
    {
        $exists = $this->model->onlyTrashed()->where('id', $id)->exists();
        throw_if(!$exists, new CustomException("Record Not Found."));
        return $this->model->onlyTrashed()->find($id)->forceDelete();
    }

    /**
     * @throws CustomException
     */
    public function deleted(array $relations = [])
    {
        try {
            return $this->model
                ->with($relations)
                ->onlyTrashed();
        } catch (\Exception $ex) {
            throw new CustomException("Record Not Found.");
        }
    }

    /**
     * @throws CustomException
     * @throws \Throwable
     */
    public function undelete($id)
    {
        $exists = $this->model->onlyTrashed()->where('id', $id)->exists();
        throw_if(!$exists, new CustomException("Record Not Found."));
        return $this->model->onlyTrashed()->where('id', $id)->restore();
    }

    /**
     * @return "locked record"
     * @throws \Throwable
     * @throws CustomException
     */
    public function lockRowForUpdate($id)
    {
        $exists = $this->model->where('id', $id)->exists();
        throw_if(!$exists, new CustomException("Record Not Found."));
        return $this->model->where('id', $id)->lockForUpdate()->first();
    }
}
