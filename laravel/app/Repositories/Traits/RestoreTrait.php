<?php

namespace App\Repositories\Traits;

/**
 * Restore trait.
 *
 * @author Douglas Serafim <douglas.serafimvr@gmail.com>
 */
trait RestoreTrait
{
    /**
     * Restore item of model by id :id.
     *
     * @param  int    $id
     * @param  string    $field
     * @return bool
     */
    public function restore($id, $field = 'id')
    {
        return $this->model->onlyTrashed()->where($field, $id)->restore();
    }
}
