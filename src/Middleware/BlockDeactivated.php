<?php

namespace NemanjaIlic\ModelDeactivator\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockDeactivated
{
    public function handle(Request $request, Closure $next): Response
    {
        $route = $request->route();
        $params = $route ? $route->parameters() : [];

        foreach ($params as $param) {
            if (is_object($param) && method_exists($param, 'getAttribute')) {
                if (array_key_exists('active', $param->getAttributes()) && !$param->active) {
                    abort(403, 'This item is currently inactive.');
                }
                if (method_exists($param, 'isTemporarilyDeactivated') && $param->isTemporarilyDeactivated()) {
                    abort(403, 'This item is temporarily inactive.');
                }
            }
        }
        return $next($request);
    }
}