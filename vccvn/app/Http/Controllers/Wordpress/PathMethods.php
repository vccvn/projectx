<?php

namespace App\Http\Controllers\Wordpress;

use Illuminate\Http\Request;


use Crazy\Helpers\Arr;

trait PathMethods{
    
    public function nessage($message = '')
    {
        return $this->viewModule('message', compact('message'));
    }

    public function notFound()
    {
        return $this->nessage('File không tồn tại');
    }

    public function getHomePath(Request $request, $user = null)
    {
        $u = $user ? $user: $request->user();
        return '/' . trim(env('WORDPRESS_CONTENT_PATH', '/var/www/vccvn/public/wp-content/'), '/').'/' . $u->client_key ;
    }

    public function getPathData(Request $request)
    {
        $user = $request->user();
        $path = $request->p?$request->p:$request->path;
        $relativePath = ltrim($path, '/');
        $homePath = $this->getHomePath($request, $user);
        if(count(explode('../', $path)) >= 2 ) return [];
        $fullPath = $homePath . ($relativePath?'/' .rtrim($relativePath, '/') : '');

        return compact('user', 'path', 'relativePath', 'fullPath', 'homePath');
    }

}