<?php

namespace App\Repositories\Locations;

use App\Repositories\Base\BaseRepository;

class WardRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Locations\WardValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'WardResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'WardCollection';

    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Locations\WardMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Locations\WardCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Ward::class;
    }

    
    public function createDataIfNotExists($data = [], $district_id = 0)
    {
        if(!isset($data['name'])) return false;
        $data['slug'] = str_slug($data['name']);
        if(!isset($data['code']) && isset($data['id'])) $data['code'] = $data['id'];
        if(!isset($data['district_id'])) $data['district_id'] = $district_id;
        // if(!isset($data['province_id']) && isset($data['parent_code'])){
        //     $data['province_id'] = $data['parent_code'];
        // }

        // if(!($district = $this->first(['province_id' => $data['province_id'], 'slug' => $data['slug']]))){
        //     $district = $this->create($data);
        // }
        if(!($district = $this->first(['district_id' => $data['district_id'], 'slug' => $data['slug']]))){
            $district = $this->create($data);
        }
        return $district;
    }
}