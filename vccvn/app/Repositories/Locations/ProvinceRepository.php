<?php

namespace App\Repositories\Locations;

use App\Repositories\Base\BaseRepository;

class ProvinceRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Locations\ProvinceValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'ProvinceResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'ProvinceCollection';

    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Locations\ProvinceMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Locations\ProvinceCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Province::class;
    }

    
    public function createDataIfNotExists($data = [], $columns = [])
    {
        if(!isset($data['name'])) return false;
        $data['slug'] = str_slug($data['name']);
        if(!($province = $this->first(['slug' => $data['slug']]))){
            $province = $this->create($data);
        }
        return $province;
    }

}