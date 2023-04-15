<?php

namespace App\Repositories\FOLDER;

use App\Repositories\Base\BaseRepository;

class NAMERepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'FOLDER\NAMEValidator';
    
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'FOLDER\MODELMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'FOLDER\MODELCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\MODEL::class;
    }

}