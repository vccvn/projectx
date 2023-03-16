<?php

namespace App\Repositories\Affiliates;

use App\Repositories\Base\BaseRepository;

class AffiliateRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Affiliates\AffiliateValidator';
    

    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Affiliates\AffiliateMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Affiliates\AffiliateCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Affiliate::class;
    }

}