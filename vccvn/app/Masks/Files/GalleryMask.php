<?php
namespace App\Masks\Files;

use App\Models\File;
use Crazy\Magic\Mask;

class GalleryMask extends Mask
{
    protected function init(){
        $this->allow(['getUrl', 'getThumbnail']);
    }

    public function onLoaded()
    {
        $this->url = $this->getUrl();
    }

}