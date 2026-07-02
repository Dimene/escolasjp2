<?php
// app/Http/Middleware/TenantMiddleware.php

namespace App\Http\Middleware;

use Closure;
use App\Services\TenantService;

class TenantMiddleware
{
    protected $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    public function handle($request, Closure $next)
    {
        // Aqui você pode acessar o tenant através do serviço
        $tenant = $this->tenantService->getTenant();

        // Continuar com o fluxo da requisição
        return $next($request);
    }
}
