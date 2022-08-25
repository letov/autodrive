<?php

namespace App\Providers;

use App\Services\Import\ImportServiceInterface;
use App\Services\Import\XMLImportService;
use Illuminate\Support\ServiceProvider;

class ImportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ImportServiceInterface::class, XMLImportService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
