<?php

namespace App\Http\Controllers\Branch;

use App\Repositories\Packages\WebAccountLimitedUpgradePaymentRepository;
use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Packages\WebAccountPackageRepository;
use App\Repositories\Payments\MethodRepository;
use Crazy\Mailer\Email;

class PackageController extends ManagerController
{
    protected $module = 'packages';

    protected $moduleName = 'Thông tin dịch vụ';

    protected $flashMode = false;

    /**
     * repository chinh
     *
     * @var WebAccountPackageRepository
     */
    public $repository;

    /**
     * @var WebAccountLimitedUpgradePaymentRepository
     */
    public $paymentRepository;

    /**
     * payment method
     *
     * @var MethodRepository
     */
    public $paymentMethodRepository = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(WebAccountPackageRepository $repository, WebAccountLimitedUpgradePaymentRepository $paymentRepository, MethodRepository $paymentMethodRepository)
    {
        $this->repository = $repository;
        $this->paymentRepository = $paymentRepository;
        $this->paymentMethodRepository = $paymentMethodRepository->addDefaultCondition('status', 'status', 1)->notTrashed();
        $this->init();
    }

    public function getInfo(Request $request)
    {
        $user = $request->user();

        $packages = $this->repository->notTrashed()->get([
            '@orderBy' => [
                'price', 'asc'
            ]
        ]);


        $settings = web_setting();
        return $this->viewModule('index', compact('user', 'settings', 'packages'));
    }

    public function upgrade(Request $request)
    {
        $validator = $this->repository->validator($request, 'Packages\WebAccountLimitedUpgradePaymentValidator');
        if(!$validator->success() || !($paymentMethod = $this->paymentMethodRepository->detail(['method' => $request->payment_method])) || !($package = $this->repository->find($request->package_id))){
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all())->with('warning_message', 'Một vài thông tin có vẻ không hợp lệ');
        }
        $user = $request->user();

        $data = new Arr($validator->inputs());

        $data->payment_method_id = $paymentMethod->id;
        $data->branch_id = $user->id;
        $data->amount = $package->price;
        $data->account_total = $package->user_limited;
        if(!($payment = $this->paymentRepository->create($data->all()))) {
            return redirect()->back()->withErrors(['payment_method.create' => 'Không thể tạo thanh toán'])->withInput($request->all())->with('warning_message', 'Một vài thông tin có vẻ không hợp lệ');
        }

        if($paymentMethod->method == 'transfer'){
            // gửi mail hướng dan thanh toan
            Email::to($user->email, $user->name)
                ->subject("Hướng dẫn thanh toán")
                ->body('mails.upgrade-transfer-payment-guide')
                ->data([
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'paymentMethod' => $paymentMethod,
                    'paymentConfig' => new Arr($paymentMethod->config),
                    'payment' => $payment,
                    'package' => $package
                ])
                ->sendAfter(1);
                session(['package_payment_id' => $payment->id]);

                return redirect()->route('payments.transfer')->with('success', 'Đăng ký mở rộng gói user thành công! Vui lòng thực hiện thanh toán để hoàn tất quá trình!');
        }
        elseif($paymentMethod->method == 'vnpay'){
            session([
                'package_payment_id' => $payment->id,
                'vnpay_bank' => $request->vnpay_bank
            ]);
            return redirect()->route('payments.vnpay-create');
        }
    }
}
