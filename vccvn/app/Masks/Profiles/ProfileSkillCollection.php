<?php
namespace App\Masks\Profiles;

use Crazy\Magic\MaskCollection;

class ProfileSkillCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return ProfileSkillMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
