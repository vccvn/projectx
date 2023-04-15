<?php

namespace App\Repositories\Crazy3D;

use App\Masks\Crazy3D\ItemRefCollection;
use App\Masks\Crazy3D\ItemRefMask;
use App\Models\Crazy3DItemRef;
use App\Repositories\Base\BaseRepository;

class ItemRefRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Crazy3D\ItemRefValidator';
    
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = ItemRefMask::class;

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = ItemRefCollection::class;

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Crazy3DItemRef::class;
    }

    /**
     * thêm item ref
     *
     * @param integer $item_id
     * @param string $ref
     * @param integer $ref_id
     * @param string $secret_key
     * @param array $settings
     * @return Crazy3DItemRef|false
     */
    public function addItem(int $item_id, string $ref, int $ref_id, string $secret_key, array $settings = []) : Crazy3DItemRef
    {
        $__data__ = compact('secret_key', 'settings');
        $data = compact('item_id', 'ref', 'ref_id', '__data__');
        if($model = $this->create($data)) return $model;
        return false;
    }

    
    /**
     * thêm item ref
     *
     * @param integer $id
     * @param string $secret_key
     * @param array $settings
     * @return Crazy3DItemRef|false
     */
    public function updateItem(int $id, string $secret_key, array $settings = []) : Crazy3DItemRef
    {
        $__data__ = compact('secret_key', 'settings');
        $data = compact('__data__');
        if($model = $this->update($id, $data)) return $model;
        return false;
    }

}