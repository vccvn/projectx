<?php

namespace App\Validators\Profiles;

use App\Validators\Base\BaseValidator;
use App\Repositories\Profiles\OrganizationRepository;

class WorkExperinceValidator extends BaseValidator
{
    public function extends()
    {
        $this->addRule('check_org', function($prop, $value){
            if(!$value) return true;
            return (new OrganizationRepository())->first(['id' => $value, 'type' => 'business']) ? true : false;
        });

    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        $data = [
            'org_id'                    => 'check_org',
            'title'                     => 'required|string|max:191',
            'description'               => 'mixed',
            'has_start_date'            => 'binary'
        ];
        if($this->has_start_date){
            $data = array_merge($data, [
                'started'                   => 'arrdate:str',
                'has_finish_date'           => 'binary',
            ]);
            if($this->has_finish_date){
                $data['finished']           = 'arrdate:str|arrdate_after:started';
            }
        }
        return $data;
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'org_id.check_org'             => 'Nơi làm việc Không hợp lệ',
            'title.required'               => 'công việc Không được bỏ trống',
            'title.string'                 => 'công việc Không hợp lệ',
            'title.max'                    => 'công việc Không hợp lệ',
            'started.arrdate'              => 'Thời gian bắt đầu Không hợp lệ',
            'finished.arrdate'             => 'Thời gian kết thúc Không hợp lệ',
            'finished.arrdate_after'       => 'Thời gian kết thúc phải sau thời gian bắt đầu',
            
        ];
    }
}