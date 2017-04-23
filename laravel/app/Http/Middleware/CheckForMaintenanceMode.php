<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CheckForMaintenanceMode {
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    public function handle($request, Closure $next)
    {
        if ($this->app->isDownForMaintenance() && ! $this->isIpWhiteListed()) {
            throw new HttpException(503);
        }

        return $next($request);
    }

    private function isIpWhiteListed()
    {
        $request = Request::capture();
        $ip = $request->ip();
        $allowed = explode(',', getenv('MANUTENCE_IPS'));

        return in_array($ip, $allowed);
    }
}
