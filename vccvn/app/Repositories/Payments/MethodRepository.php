<?php

namespace App\Repositories\Payments;

use App\Repositories\Base\BaseRepository;
use Crazy\Helpers\Arr;

class MethodRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Payments\MethodValidator';
    
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Payments\PaymentMethodMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Payments\PaymentMethodCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\PaymentMethod::class;
    }

    public function init()
    {
        $this->defaultSortBy = [
            'payment_methods.priority' => 'ASC' 
        ];
    }

    /**
     * lay cac phuong thuc duoc kich hoat
     *
     * @param array $args
     * @return array|\App\Models\PaymentMethod[]
     */
    public function getActivedMethods($args = [])
    {
        $a = array_merge(['status' => 1], $args);
        return $this->addDefaultParam('deleted', 0)->orderBy('priority', 'ASC')->get($a);
    }

    /**
     * lấy các phương thức kèm chi tiết
     *
     * @param array $args
     * @return array|\Crazy\Helpers\Arr[]|\App\Models\PaymentMethod[]
     */
    public function getActivedMethodDetails($args = [])
    {
        $arr = [];
        if(count($mths = $this->getActivedMethods($args)) && $methods = get_payment_config('methods')){
            
            foreach ($mths as $i => $method) {
                if(isset($methods[$method->method])){
                    $m = $methods[$method->method];

                    $title = $method->name?$method->name:(isset($m['name'])?$m['name']:$method->method);
                    $d = new Arr($method->toArray());
                    $d->title = $title;
                    $d->name = $title;
                    $d->value = $method->method;
                    $d->id = $method->id;
                    $detail = [];
                    if($method->config && is_array($method->config)){
                        foreach ($method->config as $key => $value) {
                            $detail[] = new Arr([
                                'label' => isset($m[$key])?$m[$key]['label']:$key,
                                'name' => $key,
                                'value' => $value,
                                
                            ]);
                        }
                    }
                    $d->detail = $detail;
                    $cd = [];
                    if(array_key_exists('data', $m)){
                        if($m['data'] && is_countable($m['data']) && count($m['data'])){
                            foreach ($m['data'] as $key => $value) {
                                $cd[$key] = new Arr($value);
                            }
                        }
                    }
                    $d->configData = new Arr($cd);
                    $d->defaultValues = array_key_exists('default_values', $m)?$m['default_values'] : [];
                    $arr[$d->method] = $d;
                }
            }
            
            return new Arr($arr);
        }
        return $arr;
    }
}