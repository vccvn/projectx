<?php

namespace App\Validators\Profiles;

use App\Validators\Base\BaseValidator;
use App\Repositories\Profiles\WorkRepository;
use App\Repositories\Profiles\AcademicRepository;
use App\Repositories\Profiles\OrganizationRepository;

class ProfileValidator extends BaseValidator
{
    public function extends()
    {

        $this->addRule('check_gender', function($attr, $value){
            if(!$value) return true;
            return in_array($value, ['male', 'female']);
        });// Thêm các rule ở đây
        $this->addRule('check_work', function($prop, $value){
            if(!$value) return true;
            return (new WorkRepository())->find($value)?true:false;
        });
        $this->addRule('check_org', function($prop, $value){
            if(!$value) return true;
            return (new OrganizationRepository())->find($value)?true:false;
        });
        $this->addRule('check_academic', function($prop, $value){
            if(!$value) return true;
            return (new AcademicRepository())->find($value)?true:false;
        });


        

    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
        $rules = [
            'first_name'          => 'required|max:191',
            'last_name'           => 'required|max:191',
            'gender'              => 'required|check_gender',
            'birthday'            => 'required|strdate',
            'address'             => 'mixed',
            'avatar'              => 'mimes:jpg,jpeg,png,gif',
            'work_id'             => 'check_work',
            'org_id'              => 'check_org',
            'academic_id'         => 'check_academic',
            'region_id'           => 'check_region',
            'district_id'         => 'check_district',
            'ward_id'             => 'check_ward',
            'email'               => 'email_or_null',
            'phone_number'        => 'phone_number',
            // thong tin tai khoan
            
        ];

        return $this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'first_name.required'                  => 'Tên không được bỏ trống',
            
            'last_name.required'                   => 'Họ và đệm không được bỏ trống',
            
            'gender.required'                      => 'Giới tính không được bỏ trống',
            'gender.chevk_gender'                  => 'Giới tính không hợp lệ',
            
            'birthday.required'                    => 'Ngày sinh không được bỏ trống',
            'birthday.strdate'                     => 'Ngày sinh không hợp lệ',
            
            'address.max'                          => 'Địa chỉ không hợp lệ',

            'avatar.required'                      => 'Ảnh đại diện không được bỏ trống',
            'avatar.mimes'                         => 'Ảnh đại diện không đúng dịnh dạng',
            'work_id.check_word'                   => 'Công việc không hợp lệ',
            'org_id.check_org'                     => 'Công ty không hợp lệ',
            'academic_id.check_academic'           => 'Học vấn không hợp lệ',

            
        ];
    }
}