<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Store;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Identify tenant from header X-Tenant-ID
        $tenantId = $request->header('X-Tenant-ID');

        if (!$tenantId) {
            // Fallback: Check subdomain if applicable, or return error
            // For MVP strictness, we demand the header for API communication
            return response()->json(['error' => 'Tenant ID required'], 400);
        }

        $store = Store::find($tenantId);

        if (!$store) {
            return response()->json(['error' => 'Tenant not found'], 404);
        }

        if (!$store->is_active) {
            return response()->json(['error' => 'Tenant is suspended'], 403);
        }

        // Set the global tenant
        app()->instance('currentTenant', $store);

        // Optional: Force database connection switch if using separate DBs
        // For this MVP, we use single DB with scoped queries

        return $next($request);
    }
}
