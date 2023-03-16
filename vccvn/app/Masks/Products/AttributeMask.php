<?php
namespace App\Masks\Products;

use App\Models\Attribute;
use Crazy\Magic\Mask;

class AttributeMask extends Mask
{

    public function init()
    {
        $this->map([
            'values' => AttributeValueCollection::class
        ]);
    }

    public function onLoaded()
    {
        $this->value = $this->{$this->value_type.'_value'}??$this->text_value;
        if(!check_model_data('product_attribute', $this->id)){
            set_model_data('product_attribute', $this->id, $this);
        }
    }
}