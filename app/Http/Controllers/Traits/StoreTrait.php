<?php
namespace App\Http\Controllers\Traits;

/**
 * Store Trait.
 *
 * @author Douglas Serafim <douglas.serafimvr@gmail.com>
 */
trait StoreTrait
{
    /**
     * Store new :item.
     *
     * @return mixed
     */
    public function store()
    {
        $request = $this->app->make($this->storeRequest());

        $save = $this->repo->store($request->all());
        if ($save) {
            return $save;
        }

        return response()->json(['error' => 'Internal error'], 500);
    }

    abstract public function storeRequest();
}
