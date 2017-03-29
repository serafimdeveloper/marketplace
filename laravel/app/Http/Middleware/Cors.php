<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 28/03/2017
 * Time: 02:16
 */

namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

}