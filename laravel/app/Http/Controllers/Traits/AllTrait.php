<?php


namespace App\Http\Controllers\Traits;

/**
 * All Trait.
 *
 * @author Douglas Serafim <douglas.serafimvr@gmail.com>
 *
 */

trait AllTrait
{
    /**
     * Get all :item.
     *
     * @return  \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return $this->repo->all($this->columns, $this->with, $this->where, $this->load);
    }
}
