<?php

namespace App\Validators\Crazy3D;

use App\Validators\Base\BaseValidator;

class ModelItemUploadValidator extends BaseValidator
{
    public function extends()
    {
        // Thêm các rule ở đây
        $this->addRule('fs', function($attr, $value){
            $e = strtolower($value->getClientOriginalExtension());
            // dd($e, get_3d_support_extensions());
            return in_array($e, get_3d_support_extensions());
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        
        return [
            'file'               => 'required|fs:'. implode(',',  get_3d_support_extensions())
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'file.required'          => 'File không dược bỏ trống',
            'file.fs'             => 'Loại tập tin không được hỗ trợ'

        ];
    }
}