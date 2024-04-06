<?php

namespace App\Repositories\Interfaces;

interface EloquentRepositoryInterface
{

    public function all(array $cols = null);

    public function create(array $attributes);

    public function insertMany(array $attributes);

    public function update($id, array $newUpdate, $column = 'id');

    public function findById($id);

    public function findByName($name, $value);

    public function findByNameSelect(array $select, $name, $value);

    public function fieldExists($fieldName, $fieldValue);

    public function selectByName($name, $value, array $select);

    public function destroy($id);

    public function forceDestroy($id);

    public function deleted(array $relations);

    public function undelete($id);

    public function lockRowForUpdate($id);
}
