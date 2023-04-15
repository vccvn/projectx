<?php

namespace App\Repositories\Crazy3D;

use App\Masks\Crazy3D\ModelItemCollection;
use App\Masks\Crazy3D\ModelItemMask;
use App\Repositories\Base\BaseRepository;

class ModelItemRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Crazy3D\ModelItemValidator';
    
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = ModelItemMask::class;

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = ModelItemCollection::class;

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Crazy3DModelItem::class;
    }


    
    /**
     * @var array $defaultSortBy Mảng key value là tên cộ và kiểu sắp xếp
     */
    protected $defaultSortBy = [
        'crazy_3d_model_items.id' => 'DESC'
    ];

    public function init()
    {
        $this->setWith('user', 'category');
        $this->perPage = 12;
        $this->setSearchable(['name', 'keywords']);
    }


}