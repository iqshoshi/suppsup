<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DatabaseMonitorCommand extends Command
{
    protected $signature = 'db:monitor';
    protected $description = 'Check database connection';

    public function handle()
    {
        try {
            DB::connection()->getPdo();
            return 0;  // Success
        } catch (\Exception $e) {
            return 1;  // Failure
        }
    }
}