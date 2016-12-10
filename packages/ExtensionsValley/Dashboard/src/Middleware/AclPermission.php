<?php

namespace ExtensionsValley\Dashboard\Middleware;

use Closure;
use Illuminate\Support\Collection;

class AclPermission
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string $role
     * @return mixed
     */
    protected $acl;

    public function handle($request, Closure $next, $param = null)
    {
          return $next($request);
    }


}
