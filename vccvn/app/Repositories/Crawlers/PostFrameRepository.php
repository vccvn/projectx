<?php

namespace App\Repositories\Crawlers;

use App\Repositories\Base\BaseRepository;

class PostFrameRepository extends FrameRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Crawlers\PostFrameValidator';

    public function init()
    {
        $this->addDefaultParam('type', 'post')->addDefaultValue('type', 'post');
    }
}