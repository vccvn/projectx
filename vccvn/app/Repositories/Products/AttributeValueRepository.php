<?php

namespace App\Repositories\Products;

use App\Repositories\Base\BaseRepository;

class AttributeValueRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass
     */
    protected $validatorClass = 'App\Validators\Products\AttributeValueValidator';
    /**
     * @var string $resource
     */
    protected $resourceClass = 'App\Http\Resources\AttributeValueResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'App\Http\Resources\AttributeValueCollection';

    protected $responseMode = 'resource';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\AttributeValue::class;
    }

    /**
     * thiết lập
     * @return void
     */
    public function init()
    {

    }


    /**
     * kiểm tra tính hợp lệ của thuộc tính sản phẩm
     *
     * @param string $name tên thuộc tính
     * @param int $attribute_value_id id giá trị thuộc tính
     * @param int $product_id ID sản phẩm
     *
     * @return boolean
     */
    public function checkAttributeValue($name, $attribute_value_id, $product_id) : bool
    {
        $this->join('attributes', 'attributes.id', '=', 'attribute_values.attribute_id')
             ->join('product_attributes', 'product_attributes.attribute_value_id', '=', 'attribute_values.id')
             ->where('attributes.name', $name)
             ->where('product_attributes.attribute_value_id', $attribute_value_id)
             ->where('product_attributes.product_id', $product_id);
        return $this->count() == 1;
    }


}
