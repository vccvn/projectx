<?php

namespace App\Crawlers;

use App\Repositories\Files\FileRepository;
use App\Repositories\Metadatas\MetadataRepository;

use Carbon\Carbon;
use Crazy\Files\Image;
use Crazy\Helpers\Arr;

class Crawler
{
    use Crawl;

    
    protected $metadatas = null;

    protected $fileRepository = null;

     /**
     * chay lai thiet lap
     */
    public function __construct()
    {
        $this->metadatas = app(MetadataRepository::class);
        $this->fileRepository = app(FileRepository::class);
        if(method_exists($this, 'init')){
            $this->init();
        }
    }

    public function __call($name, $arguments)
    {
        
    }
}