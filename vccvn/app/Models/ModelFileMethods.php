<?php

namespace App\Models;


trait ModelFileMethods
{
    /**
     * lấy về dường dẫn bí mật của user
     *
     * @param string $path
     * @return string
     */
    public function getSecretPath($path = null)
    {
        return 'static/users/' . get_secret_id($this->owner_id) . ($path ? '/' . ltrim($path) : '');
    }
}
