<?php

namespace App\Http\Controllers\Traits;
/**
 * Delete Trait.
 *
 * @author Douglas Serafim <douglas.serafimvr@gmail.com>
 */
trait DeleteTrait
{
    /**
     * Delete :item.
     *
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->repo->delete($id);
    }
}
