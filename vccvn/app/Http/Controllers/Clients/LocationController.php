<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;
use App\Repositories\Locations\DistrictRepository;
use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Locations\RegionRepository;
use App\Repositories\Locations\WardRepository;

class LocationController extends ClientController
{
    protected $module = 'locations';

    protected $moduleName = 'Địa điểm';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var RegionRepository
     */
    public $repository;
    
    /**
     * @var DistrictRepository
     *
     */
    public $districtRepository;

    /**
     * reposaitory quanr ly xa / phuong
     *
     * @var WardRepository
     */
    public $wardRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RegionRepository $repository, DistrictRepository $districtRepository, WardRepository $wardRepository)
    {
        $this->repository = $repository;
        $this->districtRepository = $districtRepository;
        $this->wardRepository = $wardRepository;
        $this->init();
    }

    public function getRegionOptions(Request $request)
    {
        extract($this->apiDefaultData);

        if($options = $this->repository->getDataOptions([], 'Chọn một')){
            $data = $options;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }

    public function getDistrictOptions(Request $request)
    {
        extract($this->apiDefaultData);

        if($options = $this->districtRepository->getDataOptions(['region_id' => $request->region_id?$request->region_id:'-1'], 'Chọn một')){
            $data = $options;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }
    
    public function getWardOptions(Request $request)
    {
        extract($this->apiDefaultData);

        if($options = $this->wardRepository->getDataOptions(['district_id' => $request->district_id?$request->district_id:'-1'], 'Chọn một')){
            $data = $options;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }
}
