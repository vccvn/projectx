<?php

namespace App\Web;

use App\Engines\CacheEngine;
use App\Repositories\Options\OptionRepository;
use Crazy\Helpers\Arr;

class Option{
    /**
     * mảng các group dưới dạng
     *
     * @var Arr[]
     */
    protected $groups = [];

    protected $cached = false;

    protected $cacheArgs = [];

    /**
     * khoi tao doi tuong option de truy cap cho de
     *
     * @param array $args
     */
    public function __construct($args = [])
    {
        if($groups = CacheEngine::get('option-group-data', $args)){
            $this->groups = $groups;
            $this->cached = true;
        }else{
            $this->cacheArgs = $args;
            $rep = app(OptionRepository::class);
            // lấy ra thông tin option
            if($option = $rep->getOptionData($args)){
                $this->addOptionGroup($option);
            }
        }
    }

    /**
     * thêm option
     *
     * @param object $option
     * @return void
     */
    public function addOptionGroup($option)
    {
        if(count($option->groups)){
            foreach ($option->groups as $group) {
                $groupData = [];
                // lấy thông tin các thiết lập trong mỗi nhóm
                if(count($group->datas)){
                    foreach ($group->datas as $optData) {
                        $val = null;
                        // kiểm tra và ep kiểu dử liệu
                        if($optData->type == 'file' && $optData->value){
                            $path = 'static/users/'.get_secret_id().'/'.$option->slug.'/'.$group->slug.'/'.$optData->value;
                            if(file_exists(public_path($path))){
                                $val = asset($path);
                            }
                            else{
                                $val = asset('static/images/default.png');
                            }

                        }
                        elseif($optData->type == 'media' && $optData->value){
                            if($file = get_media_file(['id' => $optData->value])){
                                $val = $file->source;
                            }
                        }
                        elseif($optData->type=='checklist'){
                            $val = json_decode($optData->value, true);
                        }
                        elseif ($optData->type == 'number' || $optData->value_type == 'number') {
                            $val = to_number($optData->value);
                        }elseif ($optData->value_type == 'boolean') {
                            $val = ($optData->value && $optData->value !== '0' && $optData->value !== 0  && $optData->value !== 'false') ? true : false;
                        }else{
                            $val = $optData->value;
                        }
                        $groupData[$optData->name] = $val;
                    }
                }
                $this->groups[$group->slug] = new Arr($groupData);
            }
        }
    }

    public function get($name, $default = null)
    {
        $value = $default;
        if(strlen($name)){
            $nameArr = explode('.', $name);
            $groupSlug = array_pop($nameArr);
            if(array_key_exists($groupSlug, $this->groups)){
                $group = $this->groups[$groupSlug];
                if(count($nameArr)){
                    $value = $group->getByKeyLevels($nameArr, $default);
                }else{
                    $value = $group;
                }
            }
        }
        return $value;
    }

    public function updateCache()
    {
        if(!$this->cached && $this->groups && $time = system_setting('cache_data_time', 0)){
            CacheEngine::set('option-group-data', $this->groups, $time, $this->cacheArgs);
        }
    }
    /**
     * truy cập group
     */
    public function __get($name)
    {
        return $this->get(str_slug($name));
    }

    /**
     * gọi hàm mặc định
     */
    public function __call($name, $arguments)
    {
        return $this->get($name, ...$arguments);
    }
}
