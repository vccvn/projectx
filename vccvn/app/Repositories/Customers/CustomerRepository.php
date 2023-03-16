<?php

namespace App\Repositories\Customers;

use App\Masks\Users\UserMask;
use App\Repositories\Base\BaseRepository;
use Crazy\Helpers\Arr;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;

class CustomerRepository extends BaseRepository
{
    protected $validatorClass = 'Customers\CustomerValidator';
    protected $resourceClass = 'CustomerResource';
    protected $collectionClass = 'CustomerCollection';
    protected $maskClass = 'Customers\CustomerMask';
    protected $maskCollectionClass = 'Customers\CustomerCollection';
    protected $responseMode = 'mask';
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Customer::class;
    }

    public function init()
    {
        $this->setSearchable([
            'name', 'email', 'phone_number'
        ]);
    }
    
    /**
     * tạo nếu chưa tồn tại
     * @param array $data
     * @return Customer
     */
    public function createDataIfNotExists($data = [], $columns = [])
    {
        if(!isset($data['email'])) return null;
        if($customer = $this->first(['email' => $data['email']])) return $customer;
        return $this->create($data);
    }


    /**
     * get Product option
     * @param Request $request
     * @param array $args
     * @return array
     */
    public function getSelectOptions($request, array $args = [])
    {
        return $this->getRequestDataOptions($request, $args);
    }


    public function getSessionCookieCustomerId()
    {
        $id = 0;
        if($sid = session('customer_id')){
            $id = $sid;
        }
        elseif($customer_id = Cookie::get('ci-token')){
            if(!is_numeric($customer_id)){
                $customer_id = Crypt::decryptString($customer_id);
            }
            if(is_numeric($customer_id)) $id = $customer_id;
            
        }
        return $id;
    }

    /**
     * lấy thông tin cusromer hiện tại
     *
     * @return \App\Models\Customer|null
     */
    public function getCurrentCustomer()
    {
        return ($id = $this->getSessionCookieCustomerId()) ? $this->findBy('id', $id) : null;
    }

    /**
     * lấy thông tin mua hàng từ thông tin user
     *
     * @param \App\Models\User $user
     * @return \App\Models\Customer|null
     */
    public function getCustomerByUser($user)
    {
        if($customer = $this->findBy('user_id', $user->id)){
            return $this->parseDetail($customer);
        }
        elseif($customer = $this->findBy('email', $user->email) && (!$customer->user_id || $customer->user_id == $user->id)){
            return $this->parseDetail($customer);
        }
        return null;
    }
    /**
     * lấy thông tin khách mua hàng hoặc thông tin user
     *
     * @param Request $request
     * @return \App\Masks\Users\UserMask|\App\Masks\Customers\CustomerMask|\Crazy\Helpers\Arr
     */
    public function getCurrentCustomerOrUser($request)
    {
        if($user = $request->user()){
            if($customer = $this->findBy('user_id', $user->id)){
                return $this->parseDetail($customer);
            }
            elseif($customer = $this->findBy('email', $user->email)){
                return $this->parseDetail($customer);
            }
            return new UserMask($user);
        }elseif($customer_id = $this->getSessionCookieCustomerId('customer_id')){
            if($customer = $this->findBy('id', $customer_id)){
                return $this->parseDetail($customer);
            }
            
        }
        return new Arr();
    }

    /**
     * lấy thông tin khách hàng hiện tại
     *
     * @return array
     */
    public function getCustomerParams()
    {
        $request = request();
        $data = [];

        if($user = $request->user()){
            $data['user_id'] = $user->id;
            if($customer = $this->findBy('user_id', $user->id)){
                $data['customer_id'] = $customer->id;
            }
            elseif($customer = $this->findBy('email', $user->email)){
                $data['customer_id'] = $customer->id;
            }
        }
        if($customer_id = $this->getSessionCookieCustomerId('customer_id')){
            if($customer = $this->findBy('id', $customer_id)){
                if(isset($data['customer_id'])){
                    $data['customer_id'] = [$data['customer_id'], $customer_id];
                }else{
                    $data['customer_id'] = $customer_id;
                }
            }
            
        }
        return $data;
    }

    /**
     * lấy thông tin khách hàng thông qua thông tin liên hệ như email hoặc số điện thoại
     *
     * @param string $contact
     * @return \App\Masks\Customers\CustomerMask|null
     */
    public function getCustomerByContactInfo($contact)
    {
        $this->where(function($query) use($contact){
            $query->where('email', $contact)->orWhere('phone_number', $contact);
        });
        if($customer = $this->first()){
            return $this->parseDetail($customer);
        }
        return null;
    }
}