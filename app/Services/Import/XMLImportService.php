<?php

namespace App\Services\Import;

use DOMDocument;
use RuntimeException;

class XMLImportService implements ImportServiceInterface
{

    private DOMDocument $xml;
    private const XSD_SCHEMA = 'app/Services/Import/schema/schema.xsd';

    public function __construct()
    {
        $this->xml = new DOMDocument();
    }

    public function import(string $path): void
    {
        if (!file_exists($path)) {
            throw new RuntimeException('file not exists');
        }
        $this->xml->load($path);
        if (!$this->validateSchema()) {
            throw new RuntimeException('xml file has wrong schema');
        }
        // TODO: Implement import() method.
    }

    private function validateSchema()
    {
        return $this->xml->schemaValidate(base_path() . '/' . self::XSD_SCHEMA);
    }
}
