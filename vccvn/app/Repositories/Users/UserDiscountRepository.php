<?php

namespace App\Repositories\Users;

use App\Models\UserDiscount;
use App\Repositories\Base\BaseRepository;

class UserDiscountRepository extends BaseRepository
{
    
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Users\UserDiscountMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Users\UserDiscountCollection';

    /**
     * @var \App\Models\UserDiscount
     */
    static $__Model__;

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\UserDiscount::class;
    }

    /**
     * cập nhật danh sách user discount
     *
     * @param int $discount_id
     * @param integer $quantity_per_user
     * @param array $user_ids
     * @return UserDiscount[]
     */
    public function updateUserDiscounts(int $discount_id, int $quantity_per_user = 1, array $user_ids = [])
    {
        $ignore = [];
        $userDiscounts = [];
        $total = $quantity_per_user;
        if(count($list = $this->get(['discount_id' => $discount_id]))){
            foreach ($list as $key => $userDiscount) {
                if(!in_array($userDiscount->user_id, $user_ids)){
                    $userDiscount->delete();
                }
                else{
                    $userDiscount->total = $total;
                    $userDiscount->save();
                    $ignore[] = $userDiscount->user_id;
                    $userDiscounts[] = $userDiscount;
                }
            }
        }

        if(count($user_ids)){
            $is_limited = true;
            foreach ($user_ids as $user_id) {
                if(!in_array($user_id, $ignore)){
                    if($userDiscount = $this->create(compact('discount_id', 'user_id', 'total', 'is_limited'))){
                        $userDiscounts[] = $userDiscount;
                    }
                }
            }
        }

        return $userDiscounts;
    }

}