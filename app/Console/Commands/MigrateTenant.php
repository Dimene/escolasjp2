<?php
 namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class MigrateTenant extends Command
{
    protected $signature = 'migrate:tenant {tenantId}';
    protected $description = 'Run migrations for a tenant database';

    public function handle()
    {
        $tenantId = $this->argument('tenantId');
        $databaseName = "tenant{$tenantId}_db";

        Config::set('database.connections.tenant.database', $databaseName);
        DB::purge('tenant');
        DB::reconnect('tenant');

        $this->call('migrate', [
            '--database' => 'tenant',
            '--path' => 'database/migrations/tenant',
        ]);

        $this->info("Migrations for tenant {$tenantId} completed.");
    }
}
