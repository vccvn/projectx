<?php

namespace App\Http\Controllers\Clients;

use App\Exceptions\NotReportException;
use App\Http\Controllers\Clients\ClientController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Bookings\BookingRepository;
use Crazy\Mailer\Email;

class BookingController extends ClientController
{
    protected $module = 'bookings';

    protected $moduleName = 'Booking';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var BookingRepository
     */
    public $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BookingRepository $repository)
    {
        $this->repository = $repository;

        $this->setting = setting();
        $this->siteinfo = siteinfo();
        $this->init();
    }


    /**
     * gửi liên hệ bằng ajax
     *
     * @param Request $request
     * @return Json
     */
    public function ajaxSend(Request $request)
    {
        return $this->ajaxSave($request, 'create');
    }

    /**
     * nếu trong quá trình xử lý xảy ra lỗi
     *
     * @param Request $request
     * @param array $errors
     * @return void|response
     */
    public function ajaxSaveError(Request $request, array $errors = [])
    {
        if ($request->response_type == 'text') {
            return response(implode(', ', array_values($errors)), 400);
        }
    }

    /**
     * gửi lên hệ thành công. kiểm tra kiểu data trả về nếu không phải dạng text thì bỏ qua!
     *
     * @param Request $request
     * @param array $errors
     * @return void|response
     */
    public function ajaxSaveSuccess(Request $request, $booking)
    {
        try {
            if ($this->setting->send_mail_notification) {
                $mailFrom = $this->siteinfo->email('no-reply@' . get_non_www_domain());
                $company = $this->siteinfo->company($this->siteinfo->site_name('Crazy Support'));
                $maillist = array_filter(explode(',', $this->setting->mail_notification), function ($e) {
                    return is_email($e);
                });

                if ($maillist) {
                    $d = Email::from($mailFrom, $company)
                        ->to($maillist)
                        ->replyTo($mailFrom, $company)
                        ->subject("Thông báo: Có người Booking Sản phẩm / Dịch vụ ")
                        ->body('mails.simple-alert')
                        ->data(['content' => "$booking->name vửa booking sàn phẩm / dịch vụ \nID: $booking->id\n Số lượng (Người / dịch vụ): $booking->quantity\n Thời gian: $booking->booking_time"])
                        ->send();
                }
            }
            if ($request->response_type == 'text') {
                return response("Đặt lịch thành công! \n Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất");
            }
            return $this->json([
                'status' => true,
                'message' => "Đặt lịch thành công! \n Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất"
            ]);
        } catch (NotReportException $th) {
            //throw $th;
            if ($request->response_type == 'text') {
                return response("Lỗi không xác định");
            }
            return $this->json([
                'status' => true,
                'message' => "Lỗi không xác định"
            ]);
        }
    }
}
