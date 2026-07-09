<?php

use App\Models\Annonce;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:deploy-prepare {--seed-demo : Seed demo data when the database is empty}', function (): int {
    $this->info('Preparing Laravel application for production...');

    $this->call('migrate', [
        '--force' => true,
    ]);

    try {
        $this->call('storage:link');
    } catch (Throwable $exception) {
        $this->warn('Storage link skipped: '.$exception->getMessage());
    }

    if (! $this->option('seed-demo')) {
        $this->info('Demo seed disabled. Use --seed-demo to create demo data on an empty database.');

        return 0;
    }

    if (Annonce::query()->exists()) {
        $this->info('Demo seed skipped: database already contains annonces.');

        return 0;
    }

    $this->call('db:seed', [
        '--force' => true,
    ]);

    $this->info('Production preparation completed.');

    return 0;
})->purpose('Run production-safe deployment tasks');
