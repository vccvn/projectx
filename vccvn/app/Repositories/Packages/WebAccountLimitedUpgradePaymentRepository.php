<?php

namespace App\Repositories\Packages;

use App\Repositories\Base\BaseRepository;

class WebAccountLimitedUpgradePaymentRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Packages\WebAccountLimitedUpgradePaymentValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'WebAccountLimitedUpgradePaymentResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'WebAccountLimitedUpgradePaymentCollection';

    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Packages\WebAccountLimitedUpgradePaymentMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Packages\WebAccountLimitedUpgradePaymentCollection';

    /**
     * @var \App\Models\WebAccountLimitedUpgradePayment
     */
    static $__Model__;
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\WebAccountLimitedUpgradePayment::class;
    }

}