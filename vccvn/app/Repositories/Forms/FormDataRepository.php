<?php

namespace App\Repositories\Forms;

use App\Repositories\Base\BaseRepository;

class FormDataRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Forms\FormDataValidator';
  

    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Forms\FormDataMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Forms\FormDataCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\FormData::class;
    }

}