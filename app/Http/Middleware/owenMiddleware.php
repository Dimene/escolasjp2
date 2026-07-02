<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class owenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $host = $request->getHost();


        $dadosinicias=DB::table('config')->get();


        if ($dadosinicias[0]->linkEmpresa== $host) {


            return $next($request);

    }
    else{

 return redirect()->back();

    }


    }
}
