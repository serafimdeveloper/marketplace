<?php

namespace App\Repositories\Traits;

use App\Exceptions\RepositoryException;
use Exception;

/**
 * Delete trait.
 *
 * @author Douglas Serafim <douglas.serafimvr@gmail.com>
 */
trait DeleteTrait
{
    /**
     * Destroy item of model by id :id.
     *
     * @param  int    $id
     * @return int
     */
    public function delete($id)
    {
        try {
            return $this->model->destroy($id);
        } catch (Exception $e) {
        }

        throw new RepositoryException('Could not delete the record. You must delete all relationships before proceeding.');
    }

    /**
     * Force destroy item of model by id :id.
     *
     * @param  int    $id
     * @return bool|null
     */
    public function forceDelete($id, $field = 'id')
    {
        try {
            return $this->model->where($field, $id)->forceDelete();
        } catch (Exception $e) {
        }

        throw new RepositoryException('Could not delete the record. You must delete all relationships before proceeding.');
    }
}
