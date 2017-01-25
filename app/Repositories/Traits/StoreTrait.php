<?php

namespace App\Repositories\Traits;

use App\Exceptions\RepositoryException;
use Exception;
use Log;

/**
 * Store trait.
 *
 * @author Douglas Serafim <douglas.serafimvr@gmail.com>
 */
trait StoreTrait
{
    /**
     * Store new item of model.
     *
     * @param  array  $data
     * @return Model
     *
     * @throw Exception
     */
    public function store(array $data)
    {
        if (empty($data)) {
            throw new RepositoryException('Empty data');
        }

       $model = $this->model;
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
            throw new RepositoryException('Error store');
        }
    }
}
