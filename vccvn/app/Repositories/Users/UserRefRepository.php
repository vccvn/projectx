<?php

namespace App\Repositories\Users;

use App\Repositories\Base\BaseRepository;

class UserRefRepository extends BaseRepository
{
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Users\UserRefMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Users\UserRefCollection';

    /**
     * @var \App\Models\UserRef
     */
    static $__Model__;

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\UserRef::class;
    }

    

}