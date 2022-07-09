<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class Repository implements \App\Contracts\Repositories\IRepository
{
    protected Model $model;

    protected function __construct(Model $model = null)
    {
        $this->model = $model;
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $attributes): Model
    {
        $newModel = $this->model->newInstance($attributes);
        $newModel->saveOrFail();

        return $newModel;
    }

    /**
     * {@inheritDoc}
     */
    public function update(Model $model, array $attributes): ?Model
    {
        $model->fill($attributes);
        if (! empty($model->getDirty())) {
            $model->save();

            return $model;
        }

        return null;
    }
}
