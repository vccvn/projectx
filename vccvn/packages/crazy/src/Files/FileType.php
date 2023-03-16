<?php

namespace Crazy\Files;

use Crazy\Helpers\Any;
use Crazy\Helpers\Arr;

trait FileType{
    protected $mimes = [
        '3gp' => 'video/3gpp',
        '7z' => 'application/x-7z-compressed',
        'aac' => 'audio/x-aac',
        'ai' => 'application/postscript',
        'avi' => 'video/x-msvideo',
        'bmp' => 'image/bmp',
        'css' => 'text/css',
        'csv' => 'text/csv',
        'doc' => 'application/msword',
        'docm' => 'application/vnd.ms-word.document.macroenabled.12',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'dot' => 'application/msword',
        'dotm' => 'application/vnd.ms-word.template.macroenabled.12',
        'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'exe' => 'application/x-msdownload',
        'flv' => 'video/x-flv',
        'gif' => 'image/gif',
        'h261' => 'video/h261',
        'h263' => 'video/h263',
        'h264' => 'video/h264',
        'html' => 'text/html',
        'htm' => 'text/html',
        'ico' => 'image/x-icon',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpgv' => 'video/jpeg',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'jsonml' => 'application/jsonml+json',
        'm4a' => 'audio/mp4',
        'mb' => 'application/mathematica',
        'mdb' => 'application/x-msaccess',
        'mka' => 'audio/x-matroska',
        'mkv' => 'video/x-matroska',
        'mp3' => 'audio/mpeg',
        'mp4' => 'video/mp4',
        'ogg' => 'audio/ogg',
        'ogv' => 'video/ogg',
        'ogx' => 'application/ogg',
        'pdf' => 'application/pdf',
        'png' => 'image/png',
        'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'ppt' => 'application/vnd.ms-powerpoint',
        'pptm' => 'application/vnd.ms-powerpoint.presentation.macroenabled.12',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'psd' => 'image/vnd.adobe.photoshop',
        'ras' => 'image/x-cmu-raster',
        'rgb' => 'image/x-rgb',
        'rq' => 'application/sparql-query',
        'rs' => 'application/rls-services+xml',
        'rsd' => 'application/rsd+xml',
        'rss' => 'application/rss+xml',
        'rtf' => 'application/rtf',
        'rtx' => 'text/richtext',
        's' => 'text/x-asm',
        'ser' => 'application/java-serialized-object',
        'sid' => 'image/x-mrsid-image',
        'sql' => 'application/x-sql',
        'src' => 'application/x-wais-source',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',
        'swf' => 'application/x-shockwave-flash',
        'txt' => 'text/plain',
        'text' => 'text/plain',
        'tpl' => 'application/vnd.groove-tool-template',
        'tpt' => 'application/vnd.trid.tpt',
        'tr' => 'text/troff',
        'ttf' => 'application/x-font-ttf',
        'wav' => 'audio/x-wav',
        'wbs' => 'application/vnd.criticaltools.wbs+xml',
        'weba' => 'audio/webm',
        'webm' => 'video/webm',
        'webp' => 'image/webp',
        'woff' => 'application/font-woff',
        'wri' => 'application/x-mswrite',
        'wrl' => 'model/vrml',
        'xhtml' => 'application/xhtml+xml',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xlt' => 'application/vnd.ms-excel',
        'xltm' => 'application/vnd.ms-excel.template.macroenabled.12',
        'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'xlw' => 'application/vnd.ms-excel',
        'xm' => 'audio/xm',
        'xml' => 'application/xml',
        'xsl' => 'application/xml',
        'xsm' => 'application/vnd.syncml+xml',
        'xyz' => 'chemical/x-xyz',
        'xz' => 'application/x-xz',
        'zip' => 'application/zip'
    ];
    /**
     * lấy danh sach kiểu file được hổ trợ
     * @return array
     */
    public function getMimeSupport(){
        return $this->mimes;
    }

    

    /**
     * lấy thông tin file qua mime hoac type
     * @param string $type
     * 
     * @return object Arr|Any
     */
    function getMimeType($type){
        $mimes = $this->mimes;
        $s = strtolower($type);
        if(isset($mimes[$s])){
            return new Arr([
                'extension' => $s,
                'type' => $mimes[$s]
            ]);
        }else{
            foreach ($mimes as $ext => $mime) {
                if($s == $mime){
                    return new Arr([
                        'extension' => $ext,
                        'type' => $mime
                    ]);
                }
            }
        }
        return null;
    }


    /**
     * @param string $str
     * @return Arr|null
     */
    function getBase64Data($str){
        $filename = null;
        if(count($fileinfo = explode('@', $str)) == 2){
            $filename = $fileinfo[0];
            $str = $fileinfo[1];
        }
        if(preg_match_all('/^data\:([^;]*);base64,(.*)$/si', $str, $m)){
            $type = $m[1][0];
            if($info = $this->getMimeType($type)){
                $data = base64_decode($m[2][0]);
                $extension  = $info->extension;
                $ctype = explode('/', $type);
                $filetype = $ctype[0];
                $mime = $ctype[1];
                return new Arr(compact('type', 'data', 'extension', 'filetype', 'mime', 'filename'));
            }
        }
        return null;
    }
}