<?php

namespace App\Http\Controllers\Clients;

use App\Exceptions\NotReportException;
use App\Http\Controllers\Clients\ClientController;
use App\Repositories\Metadatas\MetadataRepository;
use App\Repositories\Promos\ServicePromoRepository;
use App\Repositories\Services\PackageRepository;
use App\Repositories\Services\ServiceRepository;
use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Services\UserServiceRepository;
use Crazy\Apis\Api;

class ServiceController extends ClientController
{
    protected $module = 'services';

    protected $moduleName = 'Service';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var UserServiceRepository
     */
    public $repository;

    /**
     * Service
     *
     * @var ServiceRepository
     */
    public $serviceRepository;

    /**
     * Service
     *
     * @var ServicePromoRepository
     */
    public $servicePromoRepository;

    /**
     * Service
     *
     * @var PackageRepository
     */
    public $packageRepository;

    /**
     * @var MetadataRepository $metadataRepository
     * Quản lý meta data
     */
    protected $metadataRepository;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        UserServiceRepository $repository,
        ServiceRepository $serviceRepository,
        MetadataRepository $metadataRepository,
        PackageRepository $packageRepository,
        ServicePromoRepository $servicePromoRepository
    ) {
        $this->repository = $repository
            ->setServiceRepository($serviceRepository)
            ->setPackageRepository($packageRepository);
        $this->packageRepository = $packageRepository;
        $this->serviceRepository = $serviceRepository;
        $this->metadataRepository = $metadataRepository;
        $this->servicePromoRepository = $servicePromoRepository->notTrashed();
        $this->init();
        $this->breadcrumb->add("Gói dịch vụ", route('client.services.list'));
    }

    public function getServices(Request $request)
    {
        $userServices = $this->repository->with('transaction')->mode('mask')->getResults($request, [
            'user_id' => $request->user()->id,
            '@orderBy' => ['id', 'DESC']
        ]);

        return $this->viewModule('list', [
            'userServices' => $userServices
        ]);
    }
    public function getServices2(Request $request)
    {
        $userServices = $this->repository->mode('mask')->getResults($request, [
            'user_id' => $request->user()->id,
            '@orderBy' => ['id', 'DESC']
        ]);

        return $this->viewModule('list', [
            'userServices' => $userServices
        ]);
    }

    public function getServiceForm(Request $request)
    {
        $this->breadcrumb->add("Đăng ký dịch vụ", route('client.services.add'));
        $services = $this->serviceRepository->get([
            'deleted' => 0,
            '@with' => ['packages']
        ]);
        return $this->viewModule('add', [
            'services' => $services
        ]);
    }


    public function addService(Request $request)
    {
        $validator = $this->repository->validator($request);
        $back = redirect()->back()->withInput();
        if (!$validator->success()) {
            return $back->withErrors($validator->getErrorObject());
        } elseif (!($service = $this->serviceRepository->find($request->service_id)) || !($package = $this->packageRepository->find($request->package_id))) {
            return $back->with('error', 'Dịch vụ hoặc gói không hợp lệ');
        }

        // data là tatr61 cả các dữ liệu gử lên từ phía user
        $data = $validator->inputs();
        // thêm loại web
        $data['web_type'] = $service->web_type;
        // thêm loại tài khoản
        $data['account_type'] = $package->account_type;
        // thêm tên người dùng
        $data['name'] = $request->user()->name;
        
        $data['storage_limited'] = $package->storage_limited;

        $data['secret'] = bcrypt(env('APP_KEY'). ' - '. time());

        // dd($data);
        
        $done = false;
        // tạo và thiết lập đối tượng gọi api
        $api = new Api();
        $api->setResponseType('json');
        $price = $package->getFirstPaidAmound();
        $hasPromo = false;
        $promo_code = '';
        if($request->promo_code){
            $checkData = $this->servicePromoRepository->check($request->promo_code, $request->package_id);
            if($checkData['status']){
                $price = $checkData['price'];
                $promo_code = $request->promo_code;
                $hasPromo = true;
            }
        }
        // nếu giá bằng  0 thì khởi tạo dịch vụ
        if (!$price) {
            // lấy hạn sử dụng
            $data['expired_at'] = $package->getExpiredDate();
            $data['status'] = 1;
            $done = true;
            try {
                // tạo dữ liệu cho user
                $data['secret_key'] = web_setting()->secret_key;
                $data['client_key'] = web_setting()->client_key;
                $headerS = [
                    'VCC-CLIENT' => $data['client_key'],
                    'VCC-SECRET' => $data['secret_key']
                ];
                if($hasPromo) $data['update_owner_settings'] = 1;
                $res = $api->post('http://api.' . $data['domain'] . '/admin/accounts/create', $data, $headerS);
                if (!$res['status']) {
                    return $back->withErrors($res['errors'])->with('error', 'Không thể tạo trang web');
                }

                $data['account_id'] = $res['data'] ? $res['data']['id'] : 0;
                $data['user_id'] = $request->user()->id;
                
                if (!($userService = $this->repository->create($data))) {
                    
                    return $back->with('error', 'Không thể khởi tạo dịch vụ! Vui lòng thử lại sau giây lát');
                }

                $meta = array_copy($data, 'domain', 'subdomain', 'alias_domain');
                $data['register'] = $res['data'];
                $this->metadataRepository->saveMany('user_services', $userService->id, $meta, false);
                if($hasPromo){
                    $this->servicePromoRepository->increeUsage($promo_code);
                }
                return redirect()->route('client.services.list')->with([
                    'success' => 'Đã thêm dịch vụ thành công'
                ]);
            } catch (NotReportException $th) {
                return $back->with('error', 'Lỗi không xác định! Vui lòng thử lại sau giây lát');
            }
        }
        try {
            // kiểm tra dữ liệu hợp lệ
            $data['secret_key'] = web_setting()->secret_key;
            $data['client_key'] = web_setting()->client_key;
            $headerS = [
                'VCC-CLIENT' => $data['client_key'],
                'VCC-SECRET' => $data['secret_key']
            ];
            $res = $api->post('http://api.' . $data['domain'] . '/admin/accounts/check', $data, $headerS);
            if (!$res['status']) {
                return $back->withErrors($res['errors'])->with('error', 'Không thể tạo trang web');
            }

            $data['account_id'] = 0;
            $data['user_id'] = $request->user()->id;
                
                
            if (!($userService = $this->repository->create($data))) {
                // remove
                return $back->with('error', 'Không thể khởi tạo dịch vụ! Vui lòng thử lại sau giây lát');
            }

            $meta = array_copy($data, 'domain', 'subdomain', 'alias_domain', 'email', 'password', 'web_type', 'account_type', 'name');
            $this->metadataRepository->saveMany('user_services', $userService->id, $meta, false);

            session(['user_service_id' => $userService->id]);
            
            session(['promo_code'=>$promo_code]);
            return redirect()->route('client.services.checkout')->with([
                'success' => 'Đã thêm dịch vụ thành công! <br> Hãy làm theo hướng dẫn để thanh toán và sử dụng dịch vụ'
            ]);
            
        } catch (NotReportException $th) {
            return $back->with('error', 'Lỗi không xác định! Vui lòng thử lại sau giây lát');
        }
    }
}
