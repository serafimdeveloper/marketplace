<?php

namespace App\Http\Controllers\Traits;

/**
 * Restore Trait.
 *
 * @author Douglas Serafim <douglas.serafimvr@gmail.com>
 */
trait RestoreTrait
{
    /**
     * Restore :item.
     *
     * @return mixed
     */
    public function restore($id)
    {
        return $this->repo->restore($id);
    }
}
