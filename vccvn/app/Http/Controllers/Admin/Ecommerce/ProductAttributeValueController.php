<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Products\AttributeRepository;
use App\Repositories\Products\AttributeValueRepository;

use App\Http\Controllers\Apis\ApiController;

use Crazy\Helpers\Arr;

class ProductAttributeValueController extends ApiController
{
    protected $module = 'products.attributes.values';

    protected $moduleName = 'Thuộc tính';


    /**
     * @var App\Repositories\Products\AttributeValueRepository $repository
     */
    public $repository;

    /**
     * giá trị thuộc tính
     *
     * @var \App\Models\AttributeValue
     */
    public $attributeValue = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct( AttributeValueRepository $attributeValueRepository)
    {
        $this->repository = $attributeValueRepository;
        
        $this->init();
        
    }

    /**
     * Xử lý trước khi update. xảy ra trước before save
     *
     * @param Request $request
     * @param Arr $data
     * @param \App\Models\AttributeValue $attributeValue
     * @return void
     */
    public function beforeUpdate(Request $request, Arr $data, $attributeValue)
    {
        $this->attributeValue = $attributeValue;
    }

    /**
     * tổ chức lại dữ liệu trước khi lưu
     * @param Request $request
     * @param Crazy\Helpers\Arr
     * 
     * @return void
     */
    public function beforeSave(Request $request, Arr $data) : void
    {
        $attr = $this->validator->attribute;
        if($attr){
            //
            $valueType = $attr->value_type;
            $data->set($valueType.'_value', $data->value);
            if($valueType != 'text' && $data->text){
                $data->text_value = $data->text;
            }
            $avt = $attr->advance_value_type;
            if($avt == 'image' && $data->image){
                if($file = $this->saveBase64File($data->image, 'attribute-'.$attr->id.'-'.uniqid(), 'static/products/attributes')){
                    $data->advance_value = $file->filename;
                    if($this->attributeValue){
                        $this->attributeValue->deleteAdvanceValue();
                    }
                }
            }elseif($avt == 'color'){
                $data->advance_value = $data->color;
            }
        }else{
            $data->remove();
        }
    }


}
