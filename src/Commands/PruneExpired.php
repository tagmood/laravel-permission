<?php

namespace Spatie\Permission\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PruneExpired extends Command
{
    protected $signature = 'permission:prune-expired';

    protected $description = 'Prune expired roles and permissions';

    public function handle()
    {
        $tableNames = config('permission.table_names');

        DB::table($tableNames['model_has_roles'])
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->delete();

        $this->info('Expired roles pruned');

        DB::table($tableNames['model_has_permissions'])
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->delete();

        $this->info('Expired permissions pruned');
    }
}
