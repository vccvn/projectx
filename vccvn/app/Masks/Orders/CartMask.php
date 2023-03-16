<?php
namespace App\Masks\Orders;

use App\Engines\ViewManager;
use App\Models\Order;
use Crazy\Helpers\Arr;
use Crazy\Magic\Mask;
class CartMask extends Mask
{

    // xem thêm ExampleMask
    /**
     * thêm các thiết lập của bạn
     * ví dụ thêm danh sách cho phép truy cập vào thuộc tính hay gọi phương thức trong model
     * hoặc map vs các quan hệ dữ liệu
     *
     * @return void
     */
    protected function init(){
        $this->map([
            'details' => OrderItemCollection::class,
            'billing' => OrderAddressMask::class,
            'shipping' => OrderAddressMask::class
        ]);
    }
    public function getForm($options = [])
    {
        extract(get_web_data('__cart__form__config'));
        // $cfg = new Arr($config??[]);
        $a = get_web_data('__cart__form__data');
        $data = $a ? array_merge(Arr::setPrefix($a, 'billing_'), Arr::setPrefix($a, 'shipping_')):$a;
        $args = [
            'inputs' => $inputs??[],
            'data' => $data,
            'errors' => request()->session()->get('errors')
        ];
        $input_options = (isset($options) && $options)?$options:[];
        $form = html_form($args, $input_options, $attrs??[]);
        $form->query(['type' => ['radio', 'checkbox', 'crazyselect', 'file']])->map('removeClass', ['form-control', 'm-input']);
        // $form->query(['type' => 'checkbox'])->map('setOption', 'label_class');
        // $form->query(['type' => 'radio'])->map('setOption', 'label_class', 'm-radio');

        // $form = get_web_data('__cart__form__');
        $form->map('setTemplatePath', 'client-libs.form');
        return $form;
    }

}