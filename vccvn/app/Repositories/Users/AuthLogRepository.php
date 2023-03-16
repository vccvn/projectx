<?php

namespace App\Repositories\Users;

use App\Repositories\Base\BaseRepository;

class AuthLogRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass
     */
    protected $validatorClass = 'Users\AuthLogValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'AuthLogResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'AuthLogCollection';

    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Users\AuthLogMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Users\AuthLogCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\AuthLog::class;
    }

}
