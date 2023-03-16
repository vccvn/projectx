<?php

namespace App\Validators\Html;

use App\Repositories\Html\AreaRepository;
use App\Validators\Base\BaseValidator;

class SortComponentValidator extends BaseValidator
{
    public function checkComponents($arr)
    {
        if (!is_array($arr) || !count($arr)) return true;
        // id
        // priority
        // children
        $items = array_filter($arr, function ($item) {
            return is_array($item) && isset($item['id']) && $item['id'];
        });


        $ids = array_filter(
            array_map(function ($item) {
                return $item['id'] ? $item['id'] : 0;
            }, $items),
            function ($id) {
                return $id > 0;
            }
        );


        $childrenList = array_filter(
            array_map(function ($item) {
                return isset($item['children']) ? $item['children'] : [];
            }, $items),
            function ($child) {
                return $child > 0;
            }
        );

        $checkID = count($arr) == $this->repository->count(['id' => $ids]);
        $checkChildren = !($t = count($childrenList)) ? true : $t == count(
            array_filter(
                array_map(
                    function ($children) {
                        return $this->checkComponents($children);
                    },
                    $childrenList
                ),
                function ($stt) {
                    return $stt == true;
                }
            )
        );

        return $checkID && $checkChildren;
    }
    public function extends()
    {
        $this->addRule('check_data', function ($prop, $value) {
            if (!$value) return true;
            return $this->checkComponents($value);
        });

        $this->addRule('check_area_id', function ($prop, $value) {
            if (!$value) return false;
            return app(AreaRepository::class)->findBy('id', $value) ? true : false;
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {

        return [
            'data.*.area_id'                       => 'check_area_id',
            'data.*.components'                    => 'check_data'
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'data.*.components.check_data'               => 'Dữ liệu không hợp lệ',
            'data.*.area_id.check_area_id'           => 'Mã vùng không hợp lệ'
        ];
    }
}
