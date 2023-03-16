<?php

namespace App\Repositories\Packages;

use App\Repositories\Base\BaseRepository;

class WebAccountPackageRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Packages\WebAccountPackageValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'WebAccountPackageResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'WebAccountPackageCollection';

    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Packages\WebAccountPackageMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Packages\WebAccountPackageCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\WebAccountPackage::class;
    }

}