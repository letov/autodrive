<?php

namespace App\Console\Commands;

use App\Services\Import\ImportServiceInterface;
use App\Services\OfferService;
use Exception;
use Illuminate\Console\Command;

class ParseXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:xml {path=./data.xml}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse XML';

    public function handle(ImportServiceInterface $importService): int
    {
        $path = $this->argument('path');
        try {
            $importService->import($path);
        } catch (Exception $e) {
            $this->info($e->getMessage());
            return -1;
        }
        return 0;
    }
}
