<?php

namespace App\Repositories\Crawlers;

use App\Repositories\Base\BaseRepository;

class ProductFrameRepository extends FrameRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Crawlers\ProductFrameValidator';

    public function init()
    {
        $this->addDefaultParam('type', 'product')->addDefaultValue('type', 'product');
    }
}