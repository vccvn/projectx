<?php

namespace App\Validators\Products;

use App\Repositories\Products\ProductRepository;
use App\Validators\Base\BaseValidator;

class ReviewValidator extends BaseValidator
{
    public function extends()
    {
        $this->addRule('check_unique_customer', function ($prop, $value)
        {
            $args = [
                'product_id' => $this->product_id
            ];
            if($this->customer_id){
                $args['customer_id'] = $this->customer_id;
            }
            elseif($this->email){
                $args['email'] = $this->email;
            }
            else{
                return true;
            }
            // nếu chạy phí client thì trả về luôn kết quả là đếm số review có thông tin trùng khớp
            if($this->repository->getActor() == 'client')
                return count($args) == 1? true : ($this->repository->count($args) < 1);
            // nếu thiếu email hay custoner_id thì trả về true vì có phần khac bắt lỗi này rồi!
            if(count($args) == 1) return true;
            // trường hợp có review
            $t = count($reviews = $this->repository->get($args));
            if($t > 1) return false;
            elseif($t == 1) return $this->id ? ($this->id == $reviews[0]->id) : false;
            return true;
            
        });

        $this->addRule('check_product', function ($prop, $value)
        {
            return app(ProductRepository::class)->countBy('id', $value) == 1;
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
        $rules = [
            'product_id'                        => 'required|check_product|check_unique_customer',
            'rating'                            => 'required|numeric|min:1|max:5',
            // 'title'                             => 'required|string|max:191',
            'comment'                           => 'mixed'
        ];


        if($this->repository->getActor() != 'client' && (!$this->email || !$this->name)){
            $rules['customer_id'] = 'required|exists:customers,id';
        }
        if($this->customer_id){
            $rules['customer_id'] = 'exists:customers,id';
            $rules['name'] = 'max:191';
            $rules['email'] = 'email_or_null';
        }else{
            $rules['name'] = 'required|string|max:191';
            $rules['email'] = 'required|string|email|max:191';
        }

    
        return $rules;
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'product_id.required'               => 'Thông tin sản phẩm không được bỏ trống',
            'product_id.check_unique_customer'  => 'Mỗi khách hàng chỉ được đánh giá một lần cho mỗi sản phẩm',
            'product_id.check_product'          => 'Sản phẩm không tồn tại',
            'customer_id.required'              => 'Thông tin sản Khách hàng được bỏ trống',
            'customer_id.ezists'                => 'Khách hàng không tồn tại',
            'rating.required'                   => 'Đánh giá không dược bỏ trống',
            'rating.numeric'                    => 'Đánh giá không hợp lệ',
            'rating.min'                        => 'Thang điểm đánh giá là từ 1 đến 5',
            'rating.max'                        => 'Thang điểm đánh giá là từ 1 đến 5',
            'title.required'                    => 'Ý kiến đánh giá không được bỏ trống',
            'title.string'                      => 'Ý kiến đánh giá không hợp lệ',
            'title.max'                         => 'Ý kiến đánh giá không hợp lệ',
            'name.required'                     => 'Tên không được bỏ trống',
            'email.required'                    => 'Email không được bỏ trống',
            
            
        ];
    }
}