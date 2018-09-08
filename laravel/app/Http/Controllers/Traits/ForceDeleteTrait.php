<?php
namespace App\Http\Controllers\Traits;

/**
 * Force Delete Trait.
 *
 * @author Douglas Serafim <douglas.serafimvr@gmail.com>
 */
trait ForceDeleteTrait
{
    /**
     * Force Delete :item.
     *
     * @return mixed
     */
    public function forceDelete($id)
    {
        return $this->repo->forceDelete($id);
    }
}
