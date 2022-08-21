<?php

namespace App\Console\Commands;

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

    public function handle(): int
    {
        $path = $this->argument('path');
        return 0;
    }
}
