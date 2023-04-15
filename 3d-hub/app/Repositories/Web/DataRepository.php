<?php

namespace App\Repositories\Web;

use App\Repositories\Base\BaseRepository;

use Crazy\Helpers\Any;
use Crazy\Files\Filemanager;

class DataRepository extends BaseRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\WebData::class;
    }


    /**
     * tao moi setting
     * @param int $owner_id
     */
    public function createNewData(int $owner_id)
    {
        $filemanager = new Filemanager(base_path('json/data/web'));
        
        if($siteinfo = $filemanager->json('siteinfo')){
            foreach ($siteinfo['data'] as $info) {
                $info['owner_id'] = $owner_id;
                $this->save($info);
            }
        }
        
        if($contact = $filemanager->json('contact')){
            foreach ($contact['data'] as $info) {
                $info['owner_id'] = $owner_id;
                $this->save($info);
            }
        }

        if($sitesetting = $filemanager->json('setting')){
            foreach ($sitesetting['data'] as $info) {
                $info['owner_id'] = $owner_id;
                $this->save($info);
            }
        }
    }

    
}