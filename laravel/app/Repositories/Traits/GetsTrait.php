<?php

namespace App\Repositories\Traits;

use App\Exceptions\RepositoryException;

/**
 * Gets trait.
 *
 * @author Douglas Serafim <douglas.serafimvr@gmail.com>
 */
trait GetsTrait
{
    /**
     * Get all item of model.
     *
     * @param  array  $columns
     * @param  array  $with
     * @param  array  $where
     * @param  array  $orders
     * @param  int    $limit
     * @param  int    $page
     * @return Illuminate\Pagination\LengthAwarePaginator
     *
     * @throw Exception
     */
    public function all(array $columns = ['*'], array $with = [], array $where = [], $orders = [], $limit = 50, $page = 1)
    {
        $all = $this->model;

        if (!empty($with)) {
            $all = $all->with($with);
        }

        if (!empty($where)) {
            $all = $all->where($where);
        }

        foreach ($orders as $column => $order) {
            $all = $all->orderBy($column, $order);
        }

        $all = $all->paginate($limit, $columns, 'page', $page);

        return $all;
    }

    /**
     * Get item of model by id :id.
     *
     * @param  int    $id
     * @param  array  $columns
     * @param  array  $with
     * @param  array  $load
     * @return Illuminate\Database\Eloquent\Model
     *
     * @throw Exception
     */
    public function get($id, array $columns = ['*'], array $with = [], array $load = [])
    {
        $item = $this->model;
        if (!empty($with)) {
            $item = $item->with($with);
        }
        $item = $item->find($id, $columns);

        if (!empty($load) and !is_null($item)) {
            $item->load($load);
        }

        if ($item) {
            return $item;
        }

        throw new RepositoryException('Item not found');
    }

    /**
     * Get items of model by ids :ids.
     *
     * @param  array    $ids
     * @param  array  $columns
     * @param  array  $with
     * @param  array  $load
     * @return Illuminate\Database\Eloquent\{Collection, Model}
     *
     * @throw Exception
     */
    public function getByIds(array $ids, array $columns = ['*'], array $with = [], array $load = [])
    {
        $items = $this->model;
        if (!empty($with)) {
            $items = $items->with($with);
        }
        $items = $items->find($ids, $columns);

        if (!empty($load) and !is_null($items)) {
            $items->load($load);

            return $items;
        }

        if ($items) {
            return $items;
        }

        throw new RepositoryException('Items not found');
    }

    public function pluck($columns){
        return $this->model->pluck($columns);
    }
}
