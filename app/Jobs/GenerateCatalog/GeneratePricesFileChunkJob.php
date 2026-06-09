<?php

namespace App\Jobs\GenerateCatalog;

class GeneratePricesFileChunkJob extends AbstractJob
{
    public function __construct(private $chunk, private $fileNum)
    {
        parent::__construct();
    }
}
