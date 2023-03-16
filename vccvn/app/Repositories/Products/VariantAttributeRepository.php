<?php

namespace App\Repositories\Products;

use App\Repositories\Base\BaseRepository;

class VariantAttributeRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Products\VariantAttributeValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'ProductVariantAttributteResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'ProductVariantAttributteCollection';

    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Products\ProductVariantAttributteMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Products\ProductVariantAttributteCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\ProductVariantAttributte::class;
    }

}