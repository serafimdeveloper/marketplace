<?php
namespace App\Http\Controllers\Traits;

/**
 * Update Trait.
 *
 * @author Douglas Serafim <douglas.serafimvr@gmail.com>
 */
trait UpdateTrait
{
    /**
     * Update :item.
     *
     * @return mixed
     */
    public function update($id)
    {
        $request = $this->app->make($this->updateRequest());

        $save = $this->repo->update($request->all(), $id);
        if ($save) {
            return $save;
        }

        return response()->json(['error' => 'Internal error'], 500);
    }

    abstract public function updateRequest();
}
