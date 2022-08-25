<?php

namespace App\Services\Import;

interface ImportServiceInterface
{
    public function import(string $path): void;
}
