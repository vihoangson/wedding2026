<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Protects the /dashboard AJAX endpoints (data + invite-link encoding),
 * porting the `if (!isset($_SESSION['logged_in']))` checks from the
 * legacy dashboard/index.php.
 */
class EnsureDashboardLoggedIn
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->session()->get('dashboard_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
