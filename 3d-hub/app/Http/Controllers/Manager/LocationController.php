<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Manager\ManagerController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Locations\ProvinceRepository;
use App\Repositories\Locations\DistrictRepository;
use App\Repositories\Locations\RegionRepository;
use App\Repositories\Locations\WardRepository;
use Crazy\Apis\Api;

class LocationController extends ManagerController
{
    protected $module = 'locations';

    protected $moduleName = 'Location';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProvinceRepository $provinceRepository, DistrictRepository $districtRepository, RegionRepository $regionRepository, WardRepository $wardRepository)
    {
        $this->repository = $provinceRepository;
        $this->districtRepository = $districtRepository;
        $this->regionRepository = $regionRepository;
        $this->wardRepository = $wardRepository;
        $this->api = new Api();
        $this->init();
    }

    public function createLocations()
    {
        return $this->api->setResponseType('json')->get('https://tiki.vn/api/v2/directory/regions?country_id=VN');
    }
    public function getRegions()
    {
        $regions = $this->api->setResponseType('json')->get('https://tiki.vn/api/v2/directory/regions?country_id=VN');
        $provinces = $regions['data'];
        $hcm = $provinces[0];
        $provinces[0] = $provinces[1];
        $provinces[1] = $hcm;
        $data = [];
        foreach ($provinces as $key => $province) {
            $data[] = $this->regionRepository->createIfNotExists($province);
        }
        return $this->json($data);
    }

    public function getDistricts(Request $request)
    {
        if($region = $this->regionRepository->find($request->region_id)){
            $districtJson = $this->api->setResponseType('json')->get('https://tiki.vn/api/v2/directory/districts?region_id='.$region->code);
            $districts = $districtJson['data'];
            $d = [];
            foreach ($districts as $key => $district) {
                $d = $this->districtRepository->createIfNotExists($district, $region->id);
            }
            return '
            <p>Đã Lấy dữ liệu của '.$region->name.' Thành công!</p>
            <p>Chuẩn bị cho lần lấy tiếp theo!</p>
            <script>
                setTimeout(function(){
                    top.location.href="'.route('manager.test.get-districts', ['region_id' => $region->id + 1]).'";
                }, 1000);
            </script>';
        }
        return '<p>Không có data</p>';
    }
    
    public function getWards(Request $request)
    {
        if($district = $this->districtRepository->find($request->district_id)){
            $wardJson = $this->api->setResponseType('json')->get('https://tiki.vn/api/v2/directory/wards?district_id='.$district->code);
            $wards = $wardJson['data'];
            $d = [];
            foreach ($wards as $key => $ward) {
                $d = $this->wardRepository->createIfNotExists($ward, $district->id);
            }
            return '
            <p>Đã Lấy dữ liệu của '.$district->name.' Thành công!</p>
            <p>Chuẩn bị cho lần lấy tiếp theo!</p>
            <script>
                setTimeout(function(){
                    top.location.href="'.route('manager.test.get-wards', ['district_id' => $district->id + 1]).'";
                }, 100);
            </script>';
        }
        return '<p>Không có data</p>';
    }

    public function aaa()
    {
        $provinces = Macros::get('locations');
        $districts = Macros::get('districts');
        $positions = Macros::get('positions');
        $p = [];
        $d = [];
        if(count($provinces)){
            foreach ($provinces as $id => $name) {
                $position = isset($positions[$id])?$positions[$id]:null;
                $p[] = $this->repository->createIfNotExists(compact('name', 'position'));
            }
        }
        if(count($districts)){
            foreach ($districts as $id => $data) {
                $d[] = $this->districtRepository->createIfNotExists($data);
            }
        }
        return $this->json(['provinces' => $p, 'districts' => $d]);
    }

}
