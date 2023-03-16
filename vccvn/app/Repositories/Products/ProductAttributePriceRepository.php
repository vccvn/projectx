<?php

namespace App\Repositories\Products;

use App\Repositories\Base\BaseRepository;

class ProductAttributePriceRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Products\ProductAttributePriceValidator';
    /**
     * @var string $resource
     */
    protected $resourceClass = 'App\Http\Resources\ProductAttributePriceResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'App\Http\Resources\ProductAttributePriceCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\ProductAttributePrice::class;
    }

    /**
     * thiết lập
     * @return void
     */
    public function init()
    {

    }

}