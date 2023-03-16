<?php

namespace App\Http\Controllers\Traits;

use App\Repositories\Metadatas\MetadataRepository;
use Crazy\Apis\Api;
use Crazy\Helpers\Arr;
use Illuminate\Http\Request;
// use Crazy\Html\HTML;


use Crazy\Laravel\Router;

trait HostingMethods
{

    public function createHostingData(Request $request, $user)
    {
        $stt = true;
        
        if(!$this->repository->createOwnerData($user, $this->data, $this->is_created)){
            $stt = false;
            if ($this->is_created) {
                $this->redirectRoute = 'users.create';
                
            }
            $this->addRedirectData('error', 'Lỗi không xác định');
        }
        return $stt;
    }
}
