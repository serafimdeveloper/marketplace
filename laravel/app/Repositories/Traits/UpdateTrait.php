<?php

namespace App\Repositories\Traits;

use App\Exceptions\RepositoryException;
use Exception;
use Log;

/**
 * Update trait.
 *
 * @author Douglas Serafim <douglas.serafimvr@gmail.com>
 */
trait UpdateTrait
{
    /**
     * Update item of model.
     *
     * @param  array  $data
     * @param  int    $id
     * @return  Illuminate\Database\Eloquent\Model
     *
     * @throw Exception
     */
    public function update(array $data, $id)
    {
        if (empty($data)) {
            throw new RepositoryException('Empty data');
        }

        $model = $this->model->find($id);
        if (!$model) {
            throw new RepositoryException('Item not found');
        }
        try {
            $model->fill($data);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new RepositoryException('Empty fillable');
        }
        try {
            $model->save();
            return $model;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new RepositoryException('Error update');
        }
    }
}
