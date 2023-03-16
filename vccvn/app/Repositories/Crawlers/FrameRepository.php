<?php

namespace App\Repositories\Crawlers;

use App\Repositories\Base\BaseRepository;

class FrameRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Crawlers\FrameValidator';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\CrawlerFrame::class;
    }

    public function getSelectorFields()
    {
        return $this->_model->crawlerSelectors;
    }


        

    /**
     * lay danh sach frame cho crazy rag
     * @param array $args 
     * @param array
     */
    public static function getFrameSelectOptions(array $args = [])
    {
        return (new static())->getDataOptions($args, '-- Chọn một --', 'id', 'name');
    }
}