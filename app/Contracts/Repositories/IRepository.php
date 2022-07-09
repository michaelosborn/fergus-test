<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    /**
     * @param  array  $attributes
     * @return Model
     *
     *  @throws \Throwable
     */
    public function create(array $attributes): Model;

    /**
     * @param  Model  $model
     * @param  array  $attributes
     * @return Model|null
     */
    public function update(Model $model, array $attributes): ?Model;
}
