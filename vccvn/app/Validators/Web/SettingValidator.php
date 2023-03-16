<?php

namespace App\Validators\Web;

use App\Validators\Base\BaseValidator;

class SettingValidator extends BaseValidator
{
    protected $ownerID = 0;
    protected $userID = 0;

    public function extends()
    {
        $this->repository->reset(true)->removeDefaultConditions();
        $this->ownerID = get_owner_id();
        $this->userID = $this->user()->id;
        /**
         * kiểm tra tên miền
         *
         * @return void
         */
        $this->addRule('check_base_domain', function ($prop, $value) {
            if (!in_array($value, get_system_config('domain_list'))) return false;
            return true;
        });

        $this->addRule('check_subdomain', function ($attr, $value) {
            if (!$this->base_domain) return false;
            $manager = ['webmaster', 'master', 'webadmin', 'admin', 'administrator', 'manager', 'quantri', 'trangquantri', 'cpanel'];
            if (in_array(strtolower($value), $manager)) return false;
            if ($web = $this->repository->first(['subdomain' => $value, 'base_domain' => $this->base_domain])) {
                if ($this->ownerID == $web->owner_id) return true;
                if ($this->userID == $web->owner_id) return true;
                return false;
            }
            return true;
        });
        $this->addRule('check_alias', function ($attr, $value) {
            if ($value) return true;
            if (!$this->domain) {
                if ($web = $this->repository->first(['alias_domain' => $value])) {
                    if ($this->ownerID == $web->owner_id) return true;
                    if ($this->userID == $web->owner_id) return true;
                    return false;
                }
            } elseif ($web = $this->repository->matchIn(['alias_domain' => $value, 'domain' => $this->domain])) {
                if ($this->ownerID == $web->owner_id) return true;
                if ($this->userID == $web->owner_id) return true;
                return false;
            }

            return true;
        });

        $this->addRule('check_domain', function ($attr, $value) {
            if ($value) return true;
            if (!$this->alias_domain) {
                if ($web = $this->repository->first(['domain' => $value])) {
                    if ($this->ownerID == $web->owner_id) return true;
                    if ($this->userID == $web->owner_id) return true;
                    return false;
                }
            } elseif ($web = $this->repository->matchIn(['domain' => $value, 'alias_domain' => $this->alias_domain])) {
                if ($this->ownerID == $web->owner_id) return true;
                if ($this->userID == $web->owner_id) return true;
                return false;
            }

            return true;
        });


        $this->addRule('check_web_type', function ($attr, $value) {
            if ($list = get_system_config('web_type_list')) {
                return isset($list[$value]);
            }
            return false;
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {

        return [

            'base_domain' => 'required|check_base_domain',
            'subdomain' => 'required|check_subdomain',
            'alias_domain' => (is_subdomain() ? '' : ($this->domain? '':'required|')) . 'check_alias',
            'domain' => (is_subdomain() ? '' : ($this->alias_domain? '':'required|')) . 'check_domain',
            'ssl' => 'check_boolean'

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'web_type.required'                    => 'Bạn chưa chọn gói dịch vụ',
            'web_type.check_web_type'              => 'Gói dịch vụ không hợp lệ',
            'subdomain.required'                   => 'Bạn chưa nhập tên miền',
            'subdomain.check_subdomain'            => 'Tên miền này đã được sử dụng',
            'domain.required'                      => 'Bạn chưa nhập tên miền',
            'domain.check_domain'                  => 'Tên miền hỗ trợ không hợp lệ',
            'alias_domain.required'                => 'Bạn chưa nhập tên miền hoặc tên miền alias',
            'alias_domain.check_alias'             => 'Alias Domain đã được sử dụng',
        ];
    }
}
