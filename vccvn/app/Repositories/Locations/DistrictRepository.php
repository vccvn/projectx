<?php

namespace App\Repositories\Locations;

use App\Repositories\Base\BaseRepository;

class DistrictRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Locations\DistrictValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'DistrictResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'DistrictCollection';

    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Districts\DistrictMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Districts\DistrictCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\District::class;
    }

    public function createDataIfNotExists($data = [], $region_id = 0)
    {
        if(!isset($data['name'])) return false;
        $data['slug'] = str_slug($data['name']);
        if(!isset($data['code']) && isset($data['id'])) $data['code'] = $data['id'];
        if(!isset($data['region_id'])) $data['region_id'] = $region_id;
        // if(!isset($data['province_id']) && isset($data['parent_code'])){
        //     $data['province_id'] = $data['parent_code'];
        // }

        // if(!($district = $this->first(['province_id' => $data['province_id'], 'slug' => $data['slug']]))){
        //     $district = $this->create($data);
        // }
        if(!($district = $this->first(['region_id' => $data['region_id'], 'slug' => $data['slug']]))){
            $district = $this->create($data);
        }
        return $district;
    }
}