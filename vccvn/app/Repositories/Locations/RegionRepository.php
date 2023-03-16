<?php

namespace App\Repositories\Locations;

use App\Repositories\Base\BaseRepository;

class RegionRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Locations\RegionValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'RegionResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'RegionCollection';

    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Locations\RegionMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Locations\RegionCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Region::class;
    }

    
    public function createDataIfNotExists($data = [], $columns = [])
    {
        if(!isset($data['name'])) return false;
        $data['slug'] = str_slug($data['name']);
        if(!isset($data['code']) && isset($data['id'])) $data['code'] = $data['id'];
        if(!($province = $this->first(['slug' => $data['slug']]))){
            $province = $this->create($data);
        }
        return $province;
    }

}