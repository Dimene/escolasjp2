<?php
namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class TenantService
{
    protected $tenant;

    public function __construct()
    {
        if (app()->runningInConsole()) {
            // Evite carregar o tenant no CLI
            return;
        }

        $this->setTenant();
    }

    protected function setTenant()
    {
        $host = Request::getHost();


        if (!$host)
            abort(404, 'Host nao encontrado.');


        $subdomain = explode('.', $host)[0];
      
       // $tenant=Tenant::all();


        $this->tenant = Tenant::where('name', $subdomain)->first();
 // dd($host,  $subdomain,  $this->tenant);



        if ($this->tenant) {
            $this->setDatabaseConnection($this->tenant->bancoDados);
        } else {
            abort(404, 'Tenant not found.');
        }


    }

    protected function setDatabaseConnection($databaseName)
    {
        Config::set('database.connections.tenant.database', $databaseName);
        DB::purge('tenant');
        DB::reconnect('tenant');
        DB::setDefaultConnection('tenant');
    }

    public function getTenant()
    {
        if (app()->runningInConsole()) {
            return null; // Evite operações de banco no CLI
        }

        $dadosinicias = DB::table('config')->first();



        $dadoslayout = DB::table('configlayout')->first();

        $formadepagamentos = DB::table('anomodelos')
            ->where('id', $dadosinicias->forma_pagamento_id)
            ->first();
$nomeEm= $dadosinicias->TIpoSistema;


        session([
            'infosession' => $dadosinicias,
            'formadepagamentos' => $formadepagamentos->DescricaoTipo,
            'pagamentos' => $formadepagamentos->Descricao,
            'dadoslayout' => $dadoslayout,
            "nomeEm"=>$nomeEm
        ]);

        return $this->tenant;
    }
}
