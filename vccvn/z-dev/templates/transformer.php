<?php
namespace App\Transformers;

use App\Models\MODEL;

class NAMETransformer extends Transformer
{
    /**
     * convert model ve dang object không thể truy xuất database
     *
     * @param MODEL $model
     * @return array
     */
    public function transform(MODEL $model) : array
    {
        return [$COLUMNS
        ];
    }
}
