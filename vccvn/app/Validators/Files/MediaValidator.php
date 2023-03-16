<?php

namespace App\Validators\Files;

use App\Validators\Base\BaseValidator;

class MediaValidator extends BaseValidator
{
    public function extends()
    {
        $this->addRule('mediatypes', function ($attr, $value)
        {
            if(!is_object($value)) return false;
            $mimeType = $value->getClientMimeType();
            $extension = strtolower($value->getClientOriginalExtension());
            $types = explode('/', $mimeType);
            $type = $types[0];
            $format = $types[1];
            return (
                in_array($extension, explode(',', 'jpg,jpeg,png,gif,svg,mp3,mp4,ogg,qt,mov,h264')) || (
                    $type == 'audio' && $format == 'ogg'
                )
                || $format == 'pdf'
            
            );
            //mimes:jpg,jpeg,png,gif,mp3,mp4,ogg,qt,mov,h264,mpga,audio/ogg
        });
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        $rules = [
            'title'                            => 'max:191',
            'description'                      => 'mixed',
            'file'                             => 'required|file|max:10240|mediatypes',
        ];
        return $rules;
        // return $this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'file.mimes'                       => 'Định đạng file không được hỗ trợ',
            'file.max'                        => 'File không được vượt quá 10MB'
            
        ];
    }
}