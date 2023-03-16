<?php

namespace App\Validators\Html;

use App\Repositories\Components\ComponentRepository;
use App\Validators\Base\BaseValidator;
use Crazy\Helpers\Arr;

class ComponentValidator extends BaseValidator
{
    protected $_rules = [];
    protected $_messages = [];
    public function extends()
    {
        $componentRepository = new ComponentRepository();
        if($this->component_id && $component = $componentRepository->find($this->component_id)){
            if($component->inputs){
                $inputs = $component->inputs;
                if(is_string($inputs)){
                    $inputs = json_decode($inputs, true);
                }
                if(!is_array($inputs)) $inputs = [];
                $rules = [];
                $messages = [];
                foreach ($inputs as $key => $input) {
                    $item = new Arr($input);
                    $name = $item->name??$key;
                    $label = $item->label??$name;
                    $rule = [];
                    $type = strtolower($item->type);
                    // kiểm tra type
                    if($type == 'number'){
                        $messages[$name.'.check_number'] = $label.' phải là số';
                        $rule[] = 'check_number';
                    }elseif($type == 'boolean'){
                        $rule[] = 'check_boolean';
                    }elseif($type == 'email'){
                        $messages[$name.'.email_or_null'] = $label.' không hợp lệ';
                        $rule[] = 'email_or_null';
                    }elseif($type == 'tel'){
                        $messages[$name.'.phone_number'] = $label.' không hợp lệ';
                        $rule[] = 'phone_number';
                    }elseif($type == 'checkbox'){
                        $messages[$name.'.mixed'] = $label.' không hợp lệ';
                        $rule[] = 'mixed';
                    }elseif($type == 'file'){
                        $messages[$name.'.mimes'] = $label.' không hợp lệ';
                        $rule[] = 'mimes:jpg,jpeg,png,gif,ico,svg,doc,pdf,docx';
                        $messages[$name.'_data.base64_file'] = $label.' không hợp lệ';
                        $messages[$name.'_data.base64_size'] = $label.' Vượt quá dung luong5 cho phép (2MB)';
                        $rules[$name.'_data'] = 'base64_file:jpg,jpeg,png,gif,ico,svg,doc,pdf,docx|base64_size:2048';
                    }
    
                    // kiểm tra trong thuộc tính có kèm validate ko
                    if($validate = $item->get('@validate')){
                        if(is_array($validate)){
                            if(isset($validate['rules'])){
                                $vdata1 = $this->getValidateData(
                                    is_string($validate['rules'])?$validate['rules']:'',
                                    is_array($validate['messages'])?$validate['messages']:[],
                                    $name,
                                    $label
                                );
                                if($vdata1['rules']) $rule = array_merge($rule, $vdata1['rules']);
                                if($vdata1['messages']) $messages = array_merge($messages, $vdata1['messages']);
                            }
                        }else{
                            $vdata2 = $this->getValidateData(
                                $validate,
                                is_array($m = $item->get('@messages'))?$m:[],
                                $name,
                                $label
                            );
                            if($vdata2['rules']) $rule = array_merge($rule, $vdata2['rules']);
                            if($vdata2['messages']) $messages = array_merge($messages, $vdata2['messages']);
                            
                        }
                    }
                    if(!$rule) $rule[] = 'mixed';
                    $rules[$name] = implode('|', $rule);
                }
                $this->_rules = $rules;
                $this->_messages = $messages;
            }
        }
    }

    
    public function getValidateData($rules = null, $messages = [], $name = null, $label = null)
    {
        $ruleList = [];
        $messageList = [];
        if(is_array($rules)){
            $rs = $rules;
        }elseif($r1 = array_map(function($value){return trim($value);}, explode('|', $rules))){
            $rs = $r1;
        }
        else{
            $rs = [];
        }
        if(count($rs)){
            $ruleList = $rs;
            foreach ($rs as $value) {
                $t = explode(':', $value);
                if(!($r = trim($t[0]))){
                    $r = $value; 
                }
                if(isset($messages[$r])){
                    $messageList[$name.'.'.$r] = $messages[$r];
                }else{
                    $messageList[$name.'.'.$r] = $label. ' không hợp lệ';
                }
            }
        }
        return [
            'rules' => $ruleList,
            'messages' => $messageList
        ];
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
        return array_merge([
            'component_id' => 'exists:components,id',
            'area_id' => 'exists:html_areas,id'

        ], $this->_rules);
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return array_merge([
            'component_id.exists' => 'component Không hợp lệ',
            'area_id.exists' => 'area Không hợp lệ'
        ], $this->_messages);
    }
}