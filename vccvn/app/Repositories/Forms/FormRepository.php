<?php

namespace App\Repositories\Forms;

use App\Repositories\Base\BaseRepository;

class FormRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Forms\FormValidator';

    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Forms\FormMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Forms\FormCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Form::class;
    }

}