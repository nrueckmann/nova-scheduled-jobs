<?php

declare(strict_types=1);

namespace Llaski\NovaScheduledJobs\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authorize
{
    public function handle(Request $request, Closure $next): Response
    {
        $tool = collect(Nova::registeredTools())->first(function(Tool $tool){
            return $tool instanceof NovaScheduledJobsTool;
        });

        return optional($tool)->authorize($request) ? $next($request) : abort(403);
    }
}
