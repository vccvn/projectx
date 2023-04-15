<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Contacts\ContactRepository;

class ContactController extends ClientController
{
    protected $module = 'contacts';

    protected $moduleName = 'Contact';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ContactRepository $ContactRepository)
    {
        $this->repository = $ContactRepository;
        $this->init();
    }

    /**
     * hiển thị form
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function showForm(Request $request)
    {
        $this->breadcrumb->add("Liên hệ");
        return $this->cacheViewModule($request, 'form', null,  'contact-form');
    }


    /**
     * gửi liên hệ
     *
     * @param Request $request
     * @return Json
     */
    public function sendContact(Request $request)
    {
        return $this->save($request, 'create');
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
        if($request->response_type == 'text'){
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
    public function ajaxSaveSuccess(Request $request, $contact)
    {
        if($request->response_type == 'text'){
            return response("Gửi liên hệ thành công! Chúng tôi sẽ phản hồi trong thời gian sớm nhất");
        }
        return $this->json([
            'status' => true,
            'message' => 'Gửi liên hệ thành công!'
        ]);
    }

    /**
     * gửi liên hệ thành công sẽ làm gì đó
     *
     * @param Request $request
     * @param \App\Models\Contact $result model contact voi du lieu vua dc them thanh cong
     * 
     * @return void
     */
    public function afterCreate($request, $result)
    {
        // goi den phuoc thu xu ly thanh cong
        $this->sendContactSuccess($request, $result);
        $this->redirectRoute = 'client.alert';
        $this->addRedirectData([
            'type' => 'success',
            'message' => 'Gửi liên hệ thành công! Chúng tôi sẽ phản hồi trong thời gian sớm nhất',
            // 'link' => route('client.orders.manager'),
            // 'text' => 'Quãn lý đơn hàng'
        ]);
    }

    /**
     * gửi liên hệ thành công sẽ làm gì đó
     *
     * @param Request $request
     * @param \App\Models\Contact $result model contact voi du lieu vua dc them thanh cong
     * 
     * @return void
     */
    public function afterAjaxCreate($request, $result)
    {
        // goi den phuoc thu xu ly thanh cong
        $this->sendContactSuccess($request, $result);

    }

    /**
     * làm gi2q đó sau khi gửi liên hệ thành công
     *
     * @param Request $request
     * @param \App\Models\Contact $result model contact voi du lieu vua dc them thanh cong
     * @return void
     */
    public function sendContactSuccess($request, $result)
    {
        
    }


}
