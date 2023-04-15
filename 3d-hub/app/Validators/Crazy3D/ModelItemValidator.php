<?php

namespace App\Validators\Crazy3D;

use App\Validators\Base\BaseValidator;

class ModelItemValidator extends BaseValidator
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
            
            'name' => 'required|string|max:191',
            // 'user_id' => 'mixed',
            'category_id' => 'mixed',
            'description' => 'mixed',
            'status' => 'in_list:draft,protected,published',
            // 'secret_id' => 'mixed',
            'download_url' => 'mixed',
            // 'thumbnail' => 'mixed',
            // 'data' => 'mixed',

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'category_id.*' => 'danh mux5 Không hợp lệ',
            'name.*' => 'tên Không hợp lệ',
            'description.*' => 'Mô tả Không hợp lệ',
            'status.*' => 'Trạng thái Không hợp lệ',
            'secret_id.*' => 'secret_id Không hợp lệ',
            'download_url.*' => 'download_url Không hợp lệ',
            // 'zip_file.*' => 'zip_file Không hợp lệ',
            // 'thumbnail.*' => 'thumbnail Không hợp lệ',
            // 'data.*' => 'data Không hợp lệ',

        ];
    }
}