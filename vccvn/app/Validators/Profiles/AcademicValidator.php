<?php

namespace App\Validators\Profiles;

use App\Validators\Base\BaseValidator;

class AcademicValidator extends BaseValidator
{
    public function extends()
    {
        // Thêm các rule ở đây
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'title'                   => 'required|unique_prop',
            'keywords'                => 'mixed'
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'title.required'          => 'Tiêu đề không được bỏ trống',
            'title.unique_prop'       => $this->title . " đã tồn tại",
            
        ];
    }
}