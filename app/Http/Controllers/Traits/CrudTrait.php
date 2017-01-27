<?php

namespace App\Http\Controllers\Traits;

/**
 * Crud Trait.
 *
 * @author Douglas Serafim <douglas.serafimvr@gmail.com>
 */
trait CrudTrait
{
    use GetTrait, AllTrait, StoreTrait, UpdateTrait, DeleteTrait;
}
