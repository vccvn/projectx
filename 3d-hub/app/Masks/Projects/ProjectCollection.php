<?php
namespace App\Masks\Projects;

use Crazy\Magic\MaskCollection;

class ProjectCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return ProjectMask::class;
    }
}
